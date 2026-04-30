<?php
use yii\helpers\Html;
use backend\widgets\ActiveForm;
use yii\helpers\Url;
use common\components\ArrayCacheHelper;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */

?>


<div class="create-translation-form">

    <span class='text-success source-msg-success margin_bottom_10'></span>

    <?php $form = ActiveForm::begin(['id' => 'formTranslation']); ?>

    <?= $form->errorSummary($model) ?>

    <?php // echo $form->field($model, 'category')->dropDownList(ArrayCacheHelper::GET_ALL_DB_TABLES_NAMES(), ['prompt' => 'Select Category']) ?>
    <?=  $form->field($model, 'category')->textInput() ?>

    <?= $form->field($model, 'message')->textInput() ?>

    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? ' btn-handle-source btn btn-success' : ' btn-handle-source btn btn-primary', 'data-id' => $model->isNewRecord ? 0 : $model->id ]) ?>

    <?php ActiveForm::end(); ?>
    
</div>



<?php echo $this->registerJS("

$('.btn-handle-source').on('click', function(e){
    e.preventDefault();
    $('#gModal').find('.source-msg-success').text('');
    let id = $(this).data('id') ? $(this).data('id') : 0;
    var url = '".Url::to(['/translatemanager/language/source-form-handler?id='])."'+id;
    var data = $(this).closest('form').serialize();

    $.ajax({
        type: 'post',
        url: url,
        data: data,
        success: function (data) {
            if(!data.success) {
                $.each( data.errors, function( index, value ){
                    $('#' + index).parent('.form-group').addClass('has-error');
                    $('#' + index).siblings('.help-block').text(value);
                });
                return;
            }

            $('#gModal').find('.source-msg-success').text(data.success_msg);
            if(!id) {
                $('#gModal').find('input[type=text]').val('');
            }
        }
    }).done(function(data) {
        if($('#translates').length) {
            $.pjax.reload('#translates', {timeout: 1000});
        }
        // $('#gModal').modal('hide');
    });


});



$('#gModal').on('hidden.bs.modal', function () {
    $('.create-translation-form').remove();
    if($('#translates').length) {
        $.pjax.reload('#translates', {timeout: 3000});
    }
  })






"
);
?>