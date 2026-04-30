<?php
/**
 * @author Lajos Molnár <lajax.m@gmail.com>
 *
 * @since 1.0
 */

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $newDataProvider \yii\data\ArrayDataProvider */
/* @var $oldDataProvider \yii\data\ArrayDataProvider */

$this->context->pageTitleIcon = 'lnr-printer';
$this->context->backText= Yii::t('app', 'Back To Organizations Setup');
$this->context->backlink=Url::to(['/site/menu-page','type'=>'organizations_setup']);

$this->title = Yii::t('app', 'Scanning project');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Organizations Setup'), 'url' => ['/site/menu-page','type'=>'organizations_setup']];

$this->params['breadcrumbs'][] = $this->title;
?>

<div id="w2-info" class="alert-info alert fade show">
    <?= Yii::t('app', '{n, plural, =0{No new entries} =1{One new entry} other{# new entries}} were added!', ['n' => $newDataProvider->totalCount]) ?>
</div>

<?= $this->render('__scanNew', [
    'newDataProvider' => $newDataProvider,
]) ?>

<div id="w2-danger" class="alert alert-danger fade show">
    <?= Yii::t('app', '{n, plural, =0{No entries} =1{One entry} other{# entries}} remove!', ['n' => $oldDataProvider->totalCount]) ?>
</div>

<?= $this->render('__scanOld', [
    'oldDataProvider' => $oldDataProvider,
]) ?>