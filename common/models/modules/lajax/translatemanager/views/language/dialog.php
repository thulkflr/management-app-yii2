<?php
/**
 * @author Lajos Molnár <lajax.m@gmail.com>
 *
 * @since 1.2
 */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $languageSource \common\modules\lajax\translatemanager\models\LanguageSource */
/* @var $languageTranslate \common\modules\lajax\translatemanager\models\LanguageTranslate */
?>
<div id="translate-manager-dialog">
    <div class="translate-manager-message">
        <div class="clearfix">
            <?php $form = ActiveForm::begin([
                'id' => 'transslate-manager-change-source-form',
                'action' => ['/translatemanager/language/message'],
            ]); ?>
            <?= $form->field($languageTranslate, 'id', ['enableLabel' => false])->hiddenInput(['name' => 'id', 'id' => 'language-source-id']) ?>
            <?= $form->field($languageTranslate, 'language')->dropDownList(array_merge([
                    '' => Yii::t('app', 'Source'),
                ], $languageTranslate->getTranslatedLanguageNames()), [
                    'name' => 'language_id',
                    'id' => 'translate-manager-language-source',
                ])->label(Yii::t('app', 'Choosing the language of translation'))
            ?>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="clearfix">
            <?= Html::label(Yii::t('app', 'Text to be translated'), 'translate-manager-message') ?>
            <?= Html::textarea('translate-manager-message', $languageSource->message, ['readonly' => 'readonly', 'id' => 'translate-manager-message']) ?>
        </div>
    </div>

    <div class="translate-manager-message">
        <div class="clearfix">
            <?php $form = ActiveForm::begin([
                'id' => 'transslate-manager-translation-form',
                'method' => 'POST',
                'action' => ['/translatemanager/language/save'],
            ]); ?>
            <?= $form->field($languageTranslate, 'id', ['enableLabel' => false])->hiddenInput(['name' => 'id']) ?>
            <?= $form->field($languageTranslate, 'language', ['enableLabel' => false])->hiddenInput(['name' => 'language_id']) ?>
            <?= $form->field($languageTranslate, 'translation')->textarea(['name' => 'translation', 'class' => $languageTranslate->language]) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
