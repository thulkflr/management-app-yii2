<?php
/**
 * @author Lajos Molnár <lajax.m@gmail.com>
 *
 * @since 1.0
 */
use yii\grid\GridView;
use yii\helpers\Html;
use common\modules\lajax\translatemanager\models\Language;
use yii\widgets\Pjax;
use yii\helpers\Url;
use backend\helpers\AdminThemeHelper;

/* @var $this \yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \common\modules\lajax\translatemanager\models\searches\LanguageSearch */


$this->context->pageTitleIcon = 'lnr-text-size';
$this->context->backText= Yii::t('app', 'Back To Organizations Setup');
$this->context->backlink=Url::to(['/site/menu-page','type'=>'organizations_setup']);

$this->title = Yii::t('app', 'Oreed Translations : List of languages');
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
                <?= $this->render('@backend/views/common/tableHeadSearch.php', ['model' => $searchModel, 'uri' => Url::to(['list'])]) ?>
                <div class="btn-actions-pane-right actions-icon-btn">

                    <?= AdminThemeHelper::getFilterIcon() ?>
                </div>
            </div>
            <div class="card-body">
                <div id="filters" class="row"
                     style="display:<?=  !$isPublicSearch && Yii::$app->request->get($searchModel->formName()) ? '' : 'none' ?>">
                    <div class="col-md-12">
                        <?= $this->render('_search_list', ['model' => $searchModel]) ?>
                    </div>
                </div>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'id' => 'grid',
                    'tableOptions' => ['class' => AdminThemeHelper::getTableDeleteClass()],
                    'layout' => AdminThemeHelper::getTableLayout($dataProvider),
                    'filterSelector' => 'select[name="per-page"]',
                    'columns' => [
                        [
                            'attribute' => 'code',
                            'value' => function ($model) {
                                return isset($model->lang) ? $model->lang->code : '';
                            },
                        ],
                        [
                            'attribute' => 'name',
                            'value' => function ($model) {
                                return isset($model->lang) ? $model->lang->name : '';
                            },
                        ],
                        [
                            'format' => 'raw',
                            'attribute' => Yii::t('app', 'Statistic'),
                            'content' => function ($model) {
                                return '<div class="progress-bar-animated-alt progress"><div class="progress-bar bg-success" role="progressbar" aria-valuenow="'.$model->getDefaultOreedTranslationtSatistic($model->lang->code).'" aria-valuemin="0" aria-valuemax="100" style="width: '.$model->getDefaultOreedTranslationtSatistic($model->lang->code).'%;">' . $model->getDefaultOreedTranslationtSatistic($model->lang->code) . '%</div></div>';
                            },
                        ],
                        [
                            'label' => Yii::t('app', 'Management'),
                            'value' => function ($model) {
                                return AdminThemeHelper::getTableActions([
                                    Html::a('<i class="dropdown-icon lnr-spell-check"></i> ' . Yii::t('app', 'Edit Translation'), Url::to(['language/translate-oreed', 'language_id' => $model->lang->code]), ['class' => 'dropdown-item']),
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
