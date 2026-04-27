<?php

namespace common\models;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "country".
 *
 * @property int $id
 * @property string $name
 * @property string|null $name_ar
 * @property string|null $iso2
 * @property string $country_code
 * @property int $order
 */
class Country extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_ar', 'iso2'], 'default', 'value' => null],
            [['order'], 'default', 'value' => 0],
            [['name', 'country_code'], 'required'],
            [['order'], 'integer'],
            [['name', 'name_ar'], 'string', 'max' => 70],
            [['iso2'], 'string', 'max' => 2],
            [['country_code'], 'string', 'max' => 5],
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
            'iso2' => Yii::t('app', 'Iso2'),
            'country_code' => Yii::t('app', 'Country Code'),
            'order' => Yii::t('app', 'Order'),
        ];
    }
    public static function getCountryList(): array
    {
        $dropList = Country::find()->select(['id', 'name','order'])->distinct()->orderBy(['order'=>SORT_ASC])->indexBy('name')->all();
            return ArrayHelper::map($dropList, 'id', 'name');
    }

}


