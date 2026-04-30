<?php

use common\modules\lajax\translatemanager\models\ExportForm;
use common\modules\lajax\translatemanager\models\Language;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Response;
use common\models\Languages;
use common\components\ArrayCacheHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model ExportForm */

$this->context->pageTitleIcon = 'lnr-sownload';
$this->context->backText = Yii::t('app', 'Back To Dashboard');
$this->context->backlink = Url::to(['/site/menu-page','type'=>'organizations_setup']);


$this->title = Yii::t('app', 'Export');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Organizations Setup'), 'url' => ['/site/menu-page','type'=>'organizations_setup']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">
                <i class="header-icon lnr-upload icon-gradient bg-happy-fisher"></i>
                <?= $this->title ?>
            </div>
            <?php $form = ActiveForm::begin([]); ?>

            <div class="card-body">
                <fieldset class="box box-primary">
                    <div class="row">
                        <?= Html::label('app', '', ['class' => 'control-label']) ?>
                        <div class="form-group">
                            <?= Html::dropDownList('app', null,array_merge(ArrayCacheHelper::GET_ALL_LANGUAGES('code')), ['class'=>'form-control','prompt' => Yii::t('app', 'Select Language'), 'required' => true]) ?>
                            <?php if(!empty($error_message)) { ?>
                                <em class="text-danger"><?= $error_message ?></em>
                            <?php } ?>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="d-block text-end card-footer">
                <?= Html::submitButton(Yii::t('app', 'Export'), ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
