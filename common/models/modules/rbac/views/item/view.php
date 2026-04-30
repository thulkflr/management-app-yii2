<?php

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\DetailView;
use common\modules\rbac\RbacAsset;
use yii\helpers\Url;

RbacAsset::register($this);

/* @var $this yii\web\View */
/* @var $model \common\modules\rbac\models\AuthItemModel */

$labels = $this->context->getLabels();
$this->context->backText=  Yii::t('app', 'Back To {label}',['label'=>$labels['Items']]);
$this->context->backlink=Url::to(['index']);
$this->context->pageTitleIcon = 'pe-7s-key';


$this->title = Yii::t('app', $labels['Item'] . ' : {0}', $model->name);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Organizations Setup'), 'url' => ['/site/menu-page','type'=>'organizations_setup']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', $labels['Items']), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
$this->render('/layouts/_sidebar');
?>

<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">
                <i class="header-icon pe-7s-key icon-gradient bg-happy-fisher"></i>
                <?= $this->title ?>
            </div>
            <div class="card-body">
                <?php echo DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'name',
                        'description:ntext',
                        'ruleName',
                        'data:ntext',
                    ],
                ]); ?>
                <?php echo $this->render('../_dualListBox', [
                    'opts' => Json::htmlEncode([
                        'items' => $model->getItems(),
                    ]),
                    'assignUrl' => ['assign', 'id' => $model->name],
                    'removeUrl' => ['remove', 'id' => $model->name],
                ]); ?>
            </div>
        </div>
    </div>
</div>