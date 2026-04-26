<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Users $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($userProfileModel, 'first_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($userProfileModel, 'last_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($userProfileModel, 'country_id') ?>
    <?= $form->field($userProfileModel, 'city_id') ?>

<!--    --><?php //= $form->field($userProfileModel, "country_id")->widget(Select2::className(), [
//            'theme' => Select2::THEME_BOOTSTRAP,
//            'data' => Country::getCountryList(),
//            'options' => $select2Options + ['prompt' => Yii::t('app', 'Select Country ...'), 'onchange' => 'fillCityFiled($(this));'],
//        // 'options' => $select2Options + ['placeholder' => Yii::t('app', 'Please Select Country ...'), 'onchange' => 'geoFiled($(this));', 'class' => 'geo-filed'],
////                                'pluginEvents' => [
////                                    'select2:select' => 'function(e) { populateTableColumnsCode(e.params.data.id); }',
////                                ],
//    ]); ?>
<!--    --><?php //= $form->field($userProfileModel, "city_id")->widget(Select2::className(), [
//            'theme' => Select2::THEME_BOOTSTRAP,
//            'data' => isset($userProfileModel->country_id) ? City::getCityMapArray($userProfileModel->country_id) : [],
//            'options' => $select2Options,
//    ]); ?>
    <?= $form->field($model, 'hash_password')->passwordInput(['maxlength' => true]) ?>
    <?= $form->field($userProfileModel, 'phone')->textInput(['maxlength' => true]) ?>
    <?= $form->field($userProfileModel, 'avatar')->textInput(['maxlength' => true]) ?>
    <?= $form->field($userProfileModel, 'bio')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    //function fillCityFiled(client) {
    //    var client_id = client.val();
    //    var targetSelect = client.attr('id').replace('country_id', 'city_id');
    //    var url = '<?php //= Url::to(['/dropdown/get-city-array', 'country' => '-id-']) ?>//';
    //    var $select = $('#' + targetSelect);
    //    $select.find('option').remove().end();
    //    $.ajax({
    //        url: url.replace('-id-', client_id),
    //        success: function (data) {
    //            var select2Options = <?php //= \yii\helpers\Json::encode($select2Options + ['placeholder' => Yii::t('app', 'Please Select City ...')]) ?>//;
    //            select2Options.data = data.data;
    //            $select.select2(select2Options);
    //            $select.val(data.selected).trigger('change');
    //        }
    //    });
    //}

</script>