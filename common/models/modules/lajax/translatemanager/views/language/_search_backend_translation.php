<?php

use yii\helpers\Html;
use backend\widgets\ActiveForm;
use yii\helpers\Url;
use common\modules\lajax\translatemanager\helpers\Language;

/* @var $this yii\web\View */
/* @var $model common\models\ThirdPartySettingSearch */
/* @var $form backend\widgets\ActiveForm */
?>


<div class="col-md-12">
    <div class="card-hover-shadow-1x mb-3">
        <div class="card-header"><i class="pe-7s-filter btn-icon-wrapper"></i> <?= Yii::t('app', 'Search Filters ') ?>
        </div>
        <?php $form = ActiveForm::begin([
            'action' => ['translate-backend','language_id'=>$language_id],
            'method' => 'get',
        ]); ?>
        <div class="row mt-3">
            <div class="col-md-6">
                <?= $form->field($model, 'category')->dropdownlist( Language::getCategoriesForBackend(),['prompt' => Yii::t('app', 'Select ...')]); ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'message')->textInput(['placeholder' => Yii::t('app', 'Type To Search ...')])->label(Yii::t('app','Source')); ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'translation')->textInput(['placeholder' =>  $searchEmptyCommand ? Yii::t('app', '"{command}" to search for empty ,"{nonCommand}" for non empty.', ['nonCommand'=>$searchNonEmptyCommand,'command' => $searchEmptyCommand]) : '']); ?>
            </div>

        </div>
        <div class="d-block text-end card-footer">
             <span id="close-filter" class="me-2 btn btn-link btn-sm close-filter"><?= Yii::t('app', 'Close') ?></span>
            <a data-pjax="0"
               href="<?=Url::to(['translate','language_id'=>$language_id])?>"
               class="me-2 btn btn-link btn-sm"><?= Yii::t('app', 'Clear') ?></a>
            <button type="submit" name="filter-search-btn" value="true"
                    class="btn-shadow-primary btn btn-primary btn-lg"><?= Yii::t('app', 'Search') ?></button>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

