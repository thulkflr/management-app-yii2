<?php

use common\models\City;
use common\models\Country;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Users $model */
/** @var yii\widgets\ActiveForm $form */

$select2Options = [
        'multiple' => false,
        'theme' => Select2::THEME_BOOTSTRAP,
    //'language' => 'en-US',
        'width' => '100%',
        'tabindex' => false,
];
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($userProfileModel, 'first_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($userProfileModel, 'last_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($userProfileModel, "country_id", ['template' => ' <div class="vma-field select2-field">{label}{input}</div>{error}'])->widget(Select2::className(), [
            'theme' => Select2::THEME_BOOTSTRAP,
            'data' => Country::getCountryList(),
            'options' => $select2Options + ['prompt' => '', 'onchange' => 'fillCityFiled($(this));'],
    ])->label('Country') ?>
    <?=
    $form->field($userProfileModel, "city_id", ['template' => ' <div class="vma-field select2-field">{label}{input}</div>{error}'])->widget(Select2::className(), [
            'theme' => Select2::THEME_BOOTSTRAP,
            'data' => isset($oTimezoneLanguage->country_id) ? City::getCityMapArray($oTimezoneLanguage->country_id) : [],
            'options' => $select2Options,
    ])->label('City') ;?>
    <?= $form->field($model, 'hash_password')->passwordInput(['maxlength' => true]) ?>
    <?= $form->field($userProfileModel, 'phone')->textInput(['maxlength' => true]) ?>
<!--    --><?php //= $form->field($userProfileModel, 'avatar')->textInput(['maxlength' => true]) ?>
    <?= $form->field($userProfileModel, 'avatar')->fileInput() ?>
    <?= $form->field($userProfileModel, 'bio')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
        function fillCityFiled(client) {
            var client_id = client.val();
            var targetSelect = client.attr('id').replace('country_id', 'city_id');
            var url = '<?= Url::to(['/dropdown/get-city-array', 'country' => '-id-']) ?>';
            var $select = $('#' + targetSelect);
            $select.find('option').remove().end();
            $.ajax({
                url: url.replace('-id-', client_id),
                success: function (data) {
                    var select2Options = <?= \yii\helpers\Json::encode($select2Options + ['placeholder' => Yii::t('app', 'Please Select City ...')]) ?>;
                    select2Options.data = data.data;
                    $select.select2(select2Options);
                    $select.val(data.selected).trigger('change');
                }
            });
        }

</script>