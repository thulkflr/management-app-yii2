<?php

/* @var $this \yii\web\View */

$this->params['sidebar'] = [
    [
        'label' => Yii::t('app', 'Assignments'),
        'url' => ['assignment/index'],
    ],
    [
        'label' => Yii::t('app', 'Roles'),
        'url' => ['role/index'],
    ],
    [
        'label' => Yii::t('app', 'Permissions'),
        'url' => ['permission/index'],
    ],
    [
        'label' => Yii::t('app', 'Routes'),
        'url' => ['route/index'],
    ],
    [
        'label' => Yii::t('app', 'Rules'),
        'url' => ['rule/index'],
    ],
];
