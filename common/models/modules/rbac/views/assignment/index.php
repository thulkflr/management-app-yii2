<?php

use common\helpers\DataPresentationHelper;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\helpers\General;
use common\models\User;
use yii\helpers\Url;
use backend\helpers\AdminThemeHelper;



$this->context->pageTitleIcon = 'pe-7s-delete-user';
$this->context->backText= Yii::t('app', 'Back To Dashboard');
$this->context->backlink=Url::to(['/']);

/* @var $this \yii\web\View */
/* @var $gridViewColumns array */
/* @var $dataProvider \yii\data\ArrayDataProvider */
/* @var $searchModel \common\modules\rbac\models\search\AssignmentSearch */

$this->title = Yii::t('app', 'Manage Users Access');
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Account Settings'), 'url' => Url::to(['/settings/default/account'])];

$isPublicSearch = Yii::$app->request->get($searchModel->formName()) && count(Yii::$app->request->get($searchModel->formName())) == 1 && isset(Yii::$app->request->get($searchModel->formName())['tablePublicSearch']);
?>

<?php Pjax::begin(['timeout' => 5000]); ?>
<div class="row">

    <div class="col-md-10 offset-md-1 form-slide-area">
        <div class="row">
            <div class="col-md-6">
                <?= $this->render('@backend/views/common/tableHeadSearch.php', ['model' => $searchModel, 'uri' => Url::to(['index'])]) ?>

            </div>
            <div class="col-md-6">
                <div class="btn-actions-pane-right actions-icon-btn ">

                </div>

            </div>
        </div>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'id' => 'grid',
            'tableOptions' => ['class' => AdminThemeHelper::getTableDeleteClass('oreed-table')],
            'layout' => AdminThemeHelper::getTableLayout($dataProvider),
            'filterSelector' => 'select[name="per-page"]',
            'columns' => [
                //AdminThemeHelper::getTableDeleteColumn($searchModel->is_deleted),
                [
                    'label' => Yii::t('app', 'User'),
                    'attribute' => 'full_name',
                    'value' => function ($model) {
                        return "{$model->full_name}" . (!empty($model->mobile) ? "<br/><small>{$model->mobile}</small>" : '') . (!empty($model->email) ? "<br/><small>{$model->email}</small>" : '');
                    },
                    'format' => 'raw',
                ],
                [
                    'label' => Yii::t('app', 'User System Role'),
                    'contentOptions' => ['style' => 'width:200px; white-space: normal;'],

                    'value' => function ($model) {
                        $html = '';

                        foreach ($model->roleArray as $key => $role)
                            $html .=DataPresentationHelper::getColoredText('info',User::getStaticRoleName($role));
                        return !empty($html)?$html:DataPresentationHelper::getNoDataMessage();
                    },
                    'format' => 'raw',
                ],
                [


                    'label' => Yii::t('app', 'Authorization Role And Permission'),
                    'value' => function ($model) {
                        $html = '';

                        foreach (Yii::$app->authManager->getAssignments($model->id) as $key => $value)
                            $html .=DataPresentationHelper::getColoredText('info',$key); ;
                        return !empty($html)?$html:DataPresentationHelper::getNoDataMessage();
                    },
                    'format' => 'raw',
                ],
                //AdminThemeHelper::getTableCreatedByColumn(),
                //AdminThemeHelper::getTableCreatedAtColumn(),
                //AdminThemeHelper::getTableUpdatedAtColumn(),
                //AdminThemeHelper::getTableIsDeletedColumn(),
                [
                    'label' => Yii::t('app', 'Management'),
                    // 'visible' => !$searchModel->is_deleted,
                    'value' => function ($model) {
                        return AdminThemeHelper::getTableActions([
                            Html::a('<i class="dropdown-icon pe-7s-key"></i> ' . Yii::t('app', 'Change Access'), Url::to(['view', 'id' => $model->id]), ['class' => 'dropdown-item']),
                            //Html::a('<i class="dropdown-icon pe-7s-note"></i> ' . Yii::t('app', 'Edit'), Url::to(['update', 'id' => $model->id]), ['class' => 'dropdown-item']),
                            //Html::button('<i class="dropdown-icon lnr-trash"></i> ' . Yii::t('app', 'Delete'), ['class' => 'dropdown-item delete-btn-in-table', 'onclick' => "singleDelete('" . Url::to(['delete', 'id' => $model->id]) . "');"]),
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

<?php Pjax::end(); ?>
