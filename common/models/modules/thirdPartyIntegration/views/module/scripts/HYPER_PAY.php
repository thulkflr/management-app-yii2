<?php
/* @var $this yii\web\View */
$this->registerJs("
$( document ).ready(function() {
    if($('#dynamicmodel-test_mode').is(':checked')){
    $('#dynamicmodel-sandbox_access_token').parents('.row').css('display','inherit')
    $('#dynamicmodel-sandbox_web_hook_decrypt_key').parents('.row').css('display','inherit')
    $('#dynamicmodel-sandbox_visa_master_entity_id').parents('.row').css('display','inherit')
    $('#dynamicmodel-sandbox_recurring_visa_master_entity_id').parents('.row').css('display','inherit')
    $('#dynamicmodel-sandbox_enable_stc').parents('.row').css('display','inherit')
    $('#dynamicmodel-sandbox_stc_entity_id').parents('.row').css('display','inherit')
    $('#dynamicmodel-sandbox_enable_mada').parents('.row').css('display','inherit')
    $('#dynamicmodel-sandbox_mada_entity_id').parents('.row').css('display','inherit')
    $('#dynamicmodel-production_access_token').parents('.row').css('display','none')
    $('#dynamicmodel-production_web_hook_decrypt_key').parents('.row').css('display','none')
    $('#dynamicmodel-production_visa_master_entity_id').parents('.row').css('display','none')
    $('#dynamicmodel-production_recurring_visa_master_entity_id').parents('.row').css('display','none')
    $('#dynamicmodel-production_enable_stc').parents('.row').css('display','none')
    $('#dynamicmodel-production_stc_entity_id').parents('.row').css('display','none')
    $('#dynamicmodel-production_enable_mada').parents('.row').css('display','none')
    $('#dynamicmodel-production_mada_entity_id').parents('.row').css('display','none')
 }else{
    $('#dynamicmodel-sandbox_access_token').parents('.row').css('display','none')
    $('#dynamicmodel-sandbox_web_hook_decrypt_key').parents('.row').css('display','none')
    $('#dynamicmodel-sandbox_visa_master_entity_id').parents('.row').css('display','none')
    $('#dynamicmodel-sandbox_recurring_visa_master_entity_id').parents('.row').css('display','none')
    $('#dynamicmodel-sandbox_enable_stc').parents('.row').css('display','none')
    $('#dynamicmodel-sandbox_stc_entity_id').parents('.row').css('display','none')
    $('#dynamicmodel-sandbox_enable_mada').parents('.row').css('display','none')
    $('#dynamicmodel-sandbox_mada_entity_id').parents('.row').css('display','none')
    $('#dynamicmodel-production_access_token').parents('.row').css('display','inherit')
    $('#dynamicmodel-production_web_hook_decrypt_key').parents('.row').css('display','inherit')
    $('#dynamicmodel-production_visa_master_entity_id').parents('.row').css('display','inherit')
    $('#dynamicmodel-production_recurring_visa_master_entity_id').parents('.row').css('display','inherit')
    $('#dynamicmodel-production_enable_stc').parents('.row').css('display','inherit')
    $('#dynamicmodel-production_stc_entity_id').parents('.row').css('display','inherit')
    $('#dynamicmodel-production_enable_mada').parents('.row').css('display','inherit')
    $('#dynamicmodel-production_mada_entity_id').parents('.row').css('display','inherit')
 }
 fillEmptyFields()
});
$('#dynamicmodel-test_mode').change(function(){
 if($(this).is(':checked')){
    $('#dynamicmodel-sandbox_access_token').parents('.row').css('display','inherit')
    $('#dynamicmodel-sandbox_web_hook_decrypt_key').parents('.row').css('display','inherit')
    $('#dynamicmodel-sandbox_visa_master_entity_id').parents('.row').css('display','inherit')
    $('#dynamicmodel-sandbox_recurring_visa_master_entity_id').parents('.row').css('display','inherit')
    $('#dynamicmodel-sandbox_enable_stc').parents('.row').css('display','inherit')
    $('#dynamicmodel-sandbox_stc_entity_id').parents('.row').css('display','inherit')
    $('#dynamicmodel-sandbox_enable_mada').parents('.row').css('display','inherit')
    $('#dynamicmodel-sandbox_mada_entity_id').parents('.row').css('display','inherit')
    $('#dynamicmodel-production_access_token').parents('.row').css('display','none')
    $('#dynamicmodel-production_web_hook_decrypt_key').parents('.row').css('display','none')
    $('#dynamicmodel-production_visa_master_entity_id').parents('.row').css('display','none')
    $('#dynamicmodel-production_recurring_visa_master_entity_id').parents('.row').css('display','none')
    $('#dynamicmodel-production_enable_stc').parents('.row').css('display','none')
    $('#dynamicmodel-production_stc_entity_id').parents('.row').css('display','none')
    $('#dynamicmodel-production_enable_mada').parents('.row').css('display','none')
    $('#dynamicmodel-production_mada_entity_id').parents('.row').css('display','none')
 }else{
    $('#dynamicmodel-sandbox_access_token').parents('.row').css('display','none')
    $('#dynamicmodel-sandbox_web_hook_decrypt_key').parents('.row').css('display','none')
    $('#dynamicmodel-sandbox_visa_master_entity_id').parents('.row').css('display','none')
    $('#dynamicmodel-sandbox_recurring_visa_master_entity_id').parents('.row').css('display','none')
    $('#dynamicmodel-sandbox_enable_stc').parents('.row').css('display','none')
    $('#dynamicmodel-sandbox_stc_entity_id').parents('.row').css('display','none')
    $('#dynamicmodel-sandbox_enable_mada').parents('.row').css('display','none')
    $('#dynamicmodel-sandbox_mada_entity_id').parents('.row').css('display','none')
    $('#dynamicmodel-production_access_token').parents('.row').css('display','inherit')
    $('#dynamicmodel-production_web_hook_decrypt_key').parents('.row').css('display','inherit')
    $('#dynamicmodel-production_visa_master_entity_id').parents('.row').css('display','inherit')
    $('#dynamicmodel-production_recurring_visa_master_entity_id').parents('.row').css('display','inherit')
    $('#dynamicmodel-production_enable_stc').parents('.row').css('display','inherit')
    $('#dynamicmodel-production_stc_entity_id').parents('.row').css('display','inherit')
    $('#dynamicmodel-production_enable_mada').parents('.row').css('display','inherit')
    $('#dynamicmodel-production_mada_entity_id').parents('.row').css('display','inherit')
 }
 fillEmptyFields()
})

function fillEmptyFields(){
    if($('#dynamicmodel-sandbox_access_token').val()=='')
        $('#dynamicmodel-sandbox_access_token').val('-')
    if($('#dynamicmodel-sandbox_web_hook_decrypt_key').val()=='')
        $('#dynamicmodel-sandbox_web_hook_decrypt_key').val('-')
    if($('#dynamicmodel-sandbox_visa_master_entity_id').val()=='')
        $('#dynamicmodel-sandbox_visa_master_entity_id').val('-')
    if($('#dynamicmodel-sandbox_recurring_visa_master_entity_id').val()=='')
        $('#dynamicmodel-sandbox_recurring_visa_master_entity_id').val('-')
    if($('#dynamicmodel-sandbox_stc_entity_id').val()=='')
        $('#dynamicmodel-sandbox_stc_entity_id').val('-')
    if($('#dynamicmodel-sandbox_mada_entity_id').val()=='')
        $('#dynamicmodel-sandbox_mada_entity_id').val('-')
    if($('#dynamicmodel-production_access_token').val()=='')
        $('#dynamicmodel-production_access_token').val('-')
    if($('#dynamicmodel-production_web_hook_decrypt_key').val()=='')
        $('#dynamicmodel-production_web_hook_decrypt_key').val('-')
    if($('#dynamicmodel-production_visa_master_entity_id').val()=='')
        $('#dynamicmodel-production_visa_master_entity_id').val('-')
    if($('#dynamicmodel-production_recurring_visa_master_entity_id').val()=='')
        $('#dynamicmodel-production_recurring_visa_master_entity_id').val('-')
    if($('#dynamicmodel-production_stc_entity_id').val()=='')
        $('#dynamicmodel-production_stc_entity_id').val('-')
    if($('#dynamicmodel-production_mada_entity_id').val()=='')
        $('#dynamicmodel-production_mada_entity_id').val('-')
}


$('#dynamicmodel-sandbox_access_token').on( 'focus', function() {
    if($(this).val()=='-')
        $(this).val('')
})
$('#dynamicmodel-sandbox_web_hook_decrypt_key').on( 'focus', function() {
    if($(this).val()=='-')
        $(this).val('')
})
$('#dynamicmodel-sandbox_visa_master_entity_id').on( 'focus', function() {
    if($(this).val()=='-')
        $(this).val('')
})
$('#dynamicmodel-sandbox_recurring_visa_master_entity_id').on( 'focus', function() {
    if($(this).val()=='-')
        $(this).val('')
})
$('#dynamicmodel-sandbox_stc_entity_id').on( 'focus', function() {
    if($(this).val()=='-')
        $(this).val('')
})
$('#dynamicmodel-sandbox_mada_entity_id').on( 'focus', function() {
    if($(this).val()=='-')
        $(this).val('')
})
$('#dynamicmodel-production_access_token').on( 'focus', function() {
    if($(this).val()=='-')
        $(this).val('')
})
$('#dynamicmodel-production_web_hook_decrypt_key').on( 'focus', function() {
    if($(this).val()=='-')
        $(this).val('')
})
$('#dynamicmodel-production_visa_master_entity_id').on( 'focus', function() {
    if($(this).val()=='-')
        $(this).val('')
})
$('#dynamicmodel-production_recurring_visa_master_entity_id').on( 'focus', function() {
    if($(this).val()=='-')
        $(this).val('')
})
$('#dynamicmodel-production_stc_entity_id').on( 'focus', function() {
    if($(this).val()=='-')
        $(this).val('')
})


$('#dynamicmodel-production_mada_entity_id').on( 'focus', function() {
    if($(this).val()=='-')
        $(this).val('')
})
");
?>