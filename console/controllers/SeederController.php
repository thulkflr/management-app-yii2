<?php
namespace console\controllers;
use common\models\City;
use common\models\Country;
use Yii;
use yii\console\Controller;
use yii\helpers\BaseConsole;

class SeederController extends Controller
{
    public function actionLoadCitiesFromExcel()
    {
        $fileName = Yii::getAlias('@console') . '/files/worldcities.xlsx';

        $data = \moonland\phpexcel\Excel::widget([
            'mode' => 'import',
            'fileName' => $fileName,
            'setFirstRecordAsKeys' => true,
            'getOnlySheet' => 'sheet1',
        ]);

        if (empty($data)) {
            $this->stdout("File is empty!" . PHP_EOL, BaseConsole::FG_RED);
            return;
        }

        $this->stdout("Checking countries..." . PHP_EOL, BaseConsole::FG_YELLOW);
        $excelCountries = array_unique(array_column($data, 'country'));

        foreach ($excelCountries as $cName) {
            $name = trim($cName);
            if (!Country::find()->where(['name' => $name])->exists()) {
                $c = new Country();
                $c->name = $name;
                $c->country_code = 'N/A';
                $c->save(false);
            }
        }

        $countriesMap = Country::find()->select(['id', 'name'])->indexBy('name')->asArray()->all();

        $this->stdout("Preparing cities for batch insert..." . PHP_EOL, BaseConsole::FG_YELLOW);

        $citiesToInsert = [];
        $batchSize = 1000;
        $totalAdded = 0;

        foreach ($data as $row) {
            $cityName = trim($row['city']);
            $countryName = trim($row['country']);

            if (isset($countriesMap[$countryName])) {
                $citiesToInsert[] = [
                    'name' => $cityName,
                    'country_id' => $countriesMap[$countryName]['id'],
                ];
            }

            if (count($citiesToInsert) >= $batchSize) {
                Yii::$app->db->createCommand()
                    ->batchInsert('{{%city}}', ['name', 'country_id'], $citiesToInsert)
                    ->execute();
                $totalAdded += count($citiesToInsert);
                $this->stdout("Inserted $totalAdded cities..." . PHP_EOL, BaseConsole::FG_GREEN);
                $citiesToInsert = [];
        }

        if (!empty($citiesToInsert)) {
            Yii::$app->db->createCommand()
                ->batchInsert('{{%city}}', ['name', 'country_id'], $citiesToInsert)
                ->execute();
            $totalAdded += count($citiesToInsert);
        }

        $this->stdout("DONE! Total inserted: $totalAdded" . PHP_EOL, BaseConsole::FG_CYAN);
    }
}
}