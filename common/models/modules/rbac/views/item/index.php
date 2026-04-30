<?php

use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\helpers\General;
use yii\helpers\Url;
use backend\helpers\AdminThemeHelper;

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ArrayDataProvider */
/* @var $searchModel \common\modules\rbac\models\search\AuthItemSearch */

$this->context->pageTitleIcon = 'pe-7s-key';
$this->context->backText= Yii::t('app', 'Back To Organizations Setup');
$this->context->backlink=Url::to(['/site/menu-page','type'=>'organizations_setup']);


$labels = $this->context->getLabels();
$this->title = Yii::t('app', $labels['Items']);
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Organizations Setup'), 'url' => ['/site/menu-page','type'=>'organizations_setup']];

$isPublicSearch = Yii::$app->request->get($searchModel->formName()) && count(Yii::$app->request->get($searchModel->formName())) == 1 && isset(Yii::$app->request->get($searchModel->formName())['tablePublicSearch']);
?>
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">
                <i class="header-icon lnr-list icon-gradient bg-happy-fisher"></i>
                <?= $this->title ?>
                <?= $this->render('@backend/views/common/tableHeadSearch.php', ['model' => $searchModel, 'uri' =>Yii::$app->request->url]) ?>
                <div class="btn-actions-pane-right actions-icon-btn">
                    <a href="<?= Url::to(['create']) ?>" class="mb-2 mt-2 me-2 btn btn-outline-primary">
                        <i class="pe-7s-plus btn-icon-wrapper"></i> <?= 'Add ' . $labels['Item'] ?>
                    </a>
                        <a onclick="bulkAction('<?= Url::to(['bulk-delete']) ?>');"
                           class="mb-2 mt-2 me-2 btn btn-outline-danger bulk-delete-btn">
                            <i class="lnr-trash btn-icon-wrapper"></i> <?= Yii::t('app', 'Delete Selected') ?>
                        </a>
                    <?= AdminThemeHelper::getFilterIcon() ?>
                </div>
            </div>
            <div class="card-body">
                <div id="filters" class="row"
                     style="display:<?= !$isPublicSearch && Yii::$app->request->get($searchModel->formName()) ? '' : 'none' ?>">
                    <div class="col-md-12">
                        <?=  $this->render('_search', ['model' => $searchModel]) ?>
                    </div>
                </div>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'id' => 'grid',
                    'tableOptions' => ['class' => AdminThemeHelper::getTableDeleteClass()],
                    'layout' => AdminThemeHelper::getTableLayout($dataProvider),
                    'filterSelector' => 'select[name="per-page"]',
                    'columns' => [
                        AdminThemeHelper::getTableDeleteColumn(false),
                        [
                            'attribute' => 'name',
                            'label' => Yii::t('app', 'Name'),
                        ],
                        [
                            'attribute' => 'ruleName',
                            'label' => Yii::t('app', 'Rule Name'),
                            'filter' => ArrayHelper::map(Yii::$app->getAuthManager()->getRules(), 'name', 'name'),
                            'filterInputOptions' => ['class' => 'form-control', 'prompt' => Yii::t('app', 'Select Rule')],
                        ],
                        [
                            'attribute' => 'description',
                            'format' => 'ntext',
                            'label' => Yii::t('app', 'Description'),
                        ],
                        [
                            'label' => Yii::t('app', 'Management'),
                            //'visible' => !$searchModel->is_deleted,
                            'value' => function ($model) {
                                return AdminThemeHelper::getTableActions([
                                    Html::a('<i class="dropdown-icon pe-7s-key"></i> ' . Yii::t('app', 'Change Access'), Url::to(['view', 'id' =>  $model->name]), ['class' => 'dropdown-item']),
                                    Html::a('<i class="dropdown-icon pe-7s-note"></i> ' . Yii::t('app', 'Edit'), Url::to(['update', 'id' => $model->name]), ['class' => 'dropdown-item']),
                                    Html::button('<i class="dropdown-icon lnr-trash"></i> ' . Yii::t('app', 'Delete'), ['class' => 'dropdown-item delete-btn-in-table', 'onclick' => "singleDelete('" . Url::to(['delete', 'id' => $model->name]) . "');"]),
                                ]);
                            },
                            'format' => 'raw',
                            'options' => [
                                'width' => 20,
                            ]
                        ]
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>