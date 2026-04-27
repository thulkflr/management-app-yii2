<?php

namespace common\models;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "city".
 *
 * @property int $id
 * @property string $name
 * @property string|null $name_ar
 * @property int $country_id
 */
class City extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_ar'], 'default', 'value' => null],
            [['name', 'country_id'], 'required'],
            [['country_id'], 'integer'],
            [['name', 'name_ar'], 'string', 'max' => 70],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'name_ar' => Yii::t('app', 'Name Ar'),
            'country_id' => Yii::t('app', 'Country ID'),
        ];
    }

    public static function getCityMapArray($country_id): array
    {
        $citiesList = City::find()->where(['country_id'=>$country_id])->all();
        return ArrayHelper::map($citiesList, 'id', 'name');
    }

    public static function getCityList2($country_id): array{
        $citiesList = City::find()->where(['country_id'=>$country_id])->all();
        return  $citiesList;
    }
}
