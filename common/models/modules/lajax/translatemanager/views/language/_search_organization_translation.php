<?php

use yii\helpers\Html;
use backend\widgets\ActiveForm;
use yii\helpers\Url;
use common\modules\lajax\translatemanager\helpers\Language;

/* @var $this yii\web\View */
/* @var $model common\models\ThirdPartySettingSearch */
/* @var $form backend\widgets\ActiveForm */
?>
<div class="thr option-card">
    <?php $form = ActiveForm::begin([
        'action' => ['organization-translate','language_id'=>$language_id],
        'method' => 'get',
    ]); ?>
    <div class="row mt-3">
        <div class="col-md-<?=$language_id=='EN'?'6':'4'?>">
            <?= $form->field($model, 'category')->dropdownlist( Language::getCategories()+['yii'=>'Core Messages'],['prompt' => Yii::t('app', 'Select ...'),'value'=>is_array($model->category)?'':$model->category]); ?>
        </div>
        <?php if($language_id!='EN'){ ?>

            <div class="col-md-4">
                <?= $form->field($model, 'default_translation')->textInput(['placeholder' => Yii::t('app', 'Type To Search ...')]); ?>
            </div>
        <?php } ?>
        <div class="col-md-<?=$language_id=='EN'?'6':'4'?>">
            <?= $form->field($model, 'translation')->textInput(['placeholder' =>  $searchEmptyCommand ? Yii::t('app', '"{command}" to search for empty ,"{nonCommand}" for non empty.', ['nonCommand'=>$searchNonEmptyCommand,'command' => $searchEmptyCommand]) : '']); ?>
        </div>

    </div>
    <div class="d-block text-end card-footer">
        <span id="close-filter" class="me-2 btn btn-link btn-sm close-filter"><?= Yii::t('app', 'Close') ?></span>
        <a data-pjax="0"
           href="<?=Url::to(['organization-translate','language_id'=>$language_id])?>"
           class="me-2 btn btn-link btn-sm"><?= Yii::t('app', 'Clear') ?></a>
        <button type="submit" name="filter-search-btn" value="true"
                class="btn-shadow-primary btn btn-primary btn-lg"><?= Yii::t('app', 'Search') ?></button>
    </div>
    <?php ActiveForm::end(); ?>
</div>

