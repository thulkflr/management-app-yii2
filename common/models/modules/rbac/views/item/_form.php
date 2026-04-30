<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model \common\modules\rbac\models\AuthItemModel */

$labels = $this->context->getLabels();
$this->context->backText=  Yii::t('app', 'Back To {label}',['label'=>$labels['Items']]);
$this->context->backlink=Url::to(['index']);
$this->context->pageTitleIcon = 'pe-7s-key';

?>

<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">
                <i class="header-icon <?= $model->isNewRecord ? 'lnr-plus-circle' : 'pe-7s-note' ?>  icon-gradient bg-happy-fisher"></i>
                <?= Yii::t('app', 'Accreditation Provider Form') ?>
            </div>
            <?php $form = ActiveForm::begin([
                'id' => 'form',
                'enableAjaxValidation' => true,
            ]); ?>
            <div class="card-body">
                <?php echo $form->field($model, 'name')->textInput(['maxlength' => 64]); ?>

                <?php echo $form->field($model, 'description')->textarea(['rows' => 2]); ?>

                <?php echo $form->field($model, 'ruleName')->widget('yii\jui\AutoComplete', [
                    'options' => [
                        'class' => 'form-control',
                        'value'=>'user'

                    ],
                    'clientOptions' => [
                        'source' => array_keys(Yii::$app->authManager->getRules()),
                    ]
                ]);
                ?>

                <?php echo $form->field($model, 'data')->hiddenInput(['rows' => 6])->label(false); ?>

            </div>
            <div class="d-block text-end card-footer">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Save') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Save And Create New') : Yii::t('app', 'Update And Create New'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','value'=>'create-new','name'=>'create-new']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>