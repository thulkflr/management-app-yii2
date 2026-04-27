<?php

namespace backend\controllers;
use common\models\City;
use yii\helpers\ArrayHelper;
use yii\web\Response;

class DropdownController extends \yii\web\Controller{
    public function actionGetCityArray($country): array
    {
//        var_dump($country);
//        die();
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $cityArr = City::getCityList2($country);
        $cityArr = (\Yii::$app->language == 'ar') ? Arrayhelper::map($cityArr, 'id', 'name_ar') : Arrayhelper::map($cityArr, 'id', 'name');
        $data = [];
        foreach ($cityArr as $key => $city) {
            $data[] = ['id' => $key, 'text' => $city];
        }
        return ['data' => $data];
    }




}