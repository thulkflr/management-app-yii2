<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $model \common\modules\filemanager\models\CreateFolderForm */
?>

<?php $form = ActiveForm::begin([
    'id' => 'frmCreateFolder',
    'options' => [
        'class' => 'ajax-form',
        'ajax-form-reload-on-success' => 'true'
    ]
]); ?>
<?= $form->errorSummary($model) ?>

<?= $form->field($model, 'name') ?>

<div class="form-group text-right">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=Yii::t('app','Close')?></button>
    <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
