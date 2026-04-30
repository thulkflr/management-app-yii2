<?php

use common\modules\lajax\translatemanager\models\ImportForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model ImportForm */

$this->context->pageTitleIcon = 'lnr-upload';
$this->context->backText = Yii::t('app', 'Back To Dashboard');
$this->context->backlink = Url::to(['/site/menu-page','type'=>'organizations_setup']);

$this->title = Yii::t('app', 'Import');
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
            <?php $form = ActiveForm::begin([
                'options' => [
                    'enctype' => 'multipart/form-data',
                ],
            ]); ?>

            <div class="card-body">
                <fieldset class="box box-primary">
                    <div class="row">
                        <?= Html::label(Yii::t('app', 'Translation File'), '', ['class' => 'control-label']) ?>
                        <div class="form-group">
                            <?= Html::fileInput('translation_file', '', ['accept' => '.xlsx']) ?>
                            <?php if (!empty($error_message)) { ?>
                                <em class="text-danger"><?= $error_message ?></em>
                            <?php } ?>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="d-block text-end card-footer">
                <?= Html::submitButton(Yii::t('app', 'Import'), ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>