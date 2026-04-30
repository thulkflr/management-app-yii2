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
if(Yii::$app->isMainOrganization)
$this->context->backlink=Url::to(['/site/menu-page','type'=>'organizations_setup']);
else
    $this->context->backlink=Url::to(['/']);


$this->title = Yii::t('app', 'List of languages');
$this->params['breadcrumbs'][] = $this->title;
if(Yii::$app->isMainOrganization)
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Organizations Setup'), 'url' => ['/site/menu-page','type'=>'organizations_setup']];
else
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Account Settings'), 'url' => Url::to(['/settings/default/account'])];

$isPublicSearch = Yii::$app->request->get($searchModel->formName()) && count(Yii::$app->request->get($searchModel->formName())) == 1 && isset(Yii::$app->request->get($searchModel->formName())['tablePublicSearch']);

?>
<div class="row">

    <div class="col-md-10 offset-md-1 form-slide-area">
        <div class="row">
            <div class="col-md-6">
                <?= $this->render('@backend/views/common/tableHeadSearch.php', ['model' => $searchModel, 'uri' =>  Url::to(['organization-list'])]) ?>

            </div>
            <div class="col-md-6">
                <div class="btn-actions-pane-right actions-icon-btn ">

                </div>

            </div>
        </div>

        <?= GridView::widget([
            'formatter' => AdminThemeHelper::getEmptySettings(),
            'dataProvider' => $dataProvider,
            'id' => 'grid',
            'tableOptions' => ['class' => AdminThemeHelper::getTableDeleteClass('oreed-table')],
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
                    'attribute' => Yii::t('app', 'Oreed Translation'),
                    'content' => function ($model) {
            if( $model->lang->code=='EN')
                        return '<div class="progress-relative"><span class="progress-label"> 100%</span> <div class="progress-bar-animated-alt progress"><div class="progress-bar bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div></div>';
                        return '<div class="progress-relative"><span class="progress-label"> ' . round($model->getDefaultTranslationtatistic($model->lang->code),1) . '%</span> <div class="progress-bar-animated-alt progress"><div class="progress-bar bg-success" role="progressbar" aria-valuenow="'.$model->getDefaultTranslationtatistic($model->lang->code).'" aria-valuemin="0" aria-valuemax="100" style="width: '.$model->getDefaultTranslationtatistic($model->lang->code).'%;"></div>';
                    },
                ],
                [
                    'format' => 'raw',
                    'attribute' => Yii::t('app', 'Your Edit'),
                    'content' => function ($model) {
                        return '
<div class="progress-relative"><span class="progress-label"> ' . round($model->OrgTranslationtatistic,1) . '%</span> <div class="progress-bar-animated-alt progress">
                                      <div class="progress-bar bg-success" role="progressbar" aria-valuenow="70"
                                      aria-valuemin="0" aria-valuemax="100" style="width:' . $model->OrgTranslationtatistic . '%">
                                       
                                      </div>
                                    </div>  
                                    </div>

';
                    },
                ],
                //   AdminThemeHelper::getTableCreatedByColumn(),
                //   AdminThemeHelper::getTableCreatedAtColumn(),
                //AdminThemeHelper::getTableUpdatedAtColumn(),
                //AdminThemeHelper::getTableIsDeletedColumn(),
                [
                    'label' => Yii::t('app', 'Management'),
                    'value' => function ($model) {
                        return AdminThemeHelper::getTableActions([
                            Html::a('<i class="dropdown-icon lnr-spell-check"></i> ' . Yii::t('app', 'Edit Translation'), Url::to( ['language/organization-translate', 'language_id' => $model->lang->code]), ['class' => 'dropdown-item']),
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