<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $model \common\modules\filemanager\models\forms\PasswordConfirmationForm */
?>

<?php $form = ActiveForm::begin(['id' => 'frmConfirmByPassword']); ?>

<?= $form->errorSummary($model) ?>
<p><?= Yii::t('app', 'Please enter your password bellow to confirm this action') ?></p>
<?= $form->field($model, 'password')->passwordInput() ?>

<div class="form-group text-right">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=Yii::t('app','Close')?></button>
    <?= Html::submitButton(Yii::t('app', 'Confirm'), ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
