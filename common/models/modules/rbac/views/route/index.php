<?php

use yii\helpers\Html;
use yii\helpers\Json;
use common\modules\rbac\RbacRouteAsset;
use yii\helpers\Url;

RbacRouteAsset::register($this);

/* @var $this yii\web\View */
/* @var $routes array */

$this->context->pageTitleIcon = 'pe-7s-browser';
$this->context->backText= Yii::t('app', 'Back To Dashboard');
$this->context->backlink=Url::to(['/site/menu-page','type'=>'organizations_setup']);


$this->title = Yii::t('app', 'All System Routes Management');
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Organizations Setup'), 'url' => ['/site/menu-page','type'=>'organizations_setup']];
$this->render('/layouts/_sidebar');
?>
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">
                <i class="header-icon pe-7s-browser icon-gradient bg-happy-fisher"></i>
                <?= $this->title ?>
                <div class="btn-actions-pane-right actions-icon-btn">
                    <a href="<?= Url::to(['refresh']) ?>" class="mb-2 mt-2 me-2 btn btn-outline-primary" id="btn-refresh">
                        <i class="pe-7s-refresh-2 btn-icon-wrapper"></i> <?= Yii::t('app', 'Rescan All System Routs') ?>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <?php echo $this->render('../_dualListBox', [
                    'opts' => Json::htmlEncode([
                        'items' => $routes,
                    ]),
                    'assignUrl' => ['assign'],
                    'removeUrl' => ['remove'],
                ]); ?>
            </div>
        </div>
    </div>
</div>



