<?php

/**
 * @author Lajos Molnár <lajax.m@gmail.com>
 *
 * @since 1.0
 */

use common\modules\lajax\translatemanager\models\OrganizationLanguageTranslate;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use backend\widgets\ActiveForm;
use common\modules\lajax\translatemanager\helpers\Language;
use common\modules\lajax\translatemanager\models\Language as Lang;
use common\components\GeneralHelpers;
use yii\helpers\Url;
use backend\helpers\AdminThemeHelper;

/* @var $this \yii\web\View */
/* @var $language_id string */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \common\modules\lajax\translatemanager\models\searches\LanguageSourceSearch */
/* @var $searchEmptyCommand string */

$this->context->pageTitleIcon = 'lnr-text-size';
$this->context->backText = Yii::t('app', 'Back To Languages');
$this->context->backlink = Url::to(['organization-list']);

$this->title = Yii::t('app', 'Translation For {language_id}', ['language_id' => $language_id]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Account Settings'), 'url' => Url::to(['/settings/default/account'])];

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Languages'), 'url' => ['organization-list']];

$this->params['breadcrumbs'][] = $this->title;

$languagesTitles = [
    'AR' => Yii::t('app', 'Arabic'),
    'EN' => Yii::t('app', 'English'),
    'FR' => Yii::t('app', 'French'),
];
$isPublicSearch = Yii::$app->request->get($searchModel->formName()) && count(Yii::$app->request->get($searchModel->formName())) == 1 && isset(Yii::$app->request->get($searchModel->formName())['tablePublicSearch']);
?>
    <div class="row">

        <div class="col-md-10 offset-md-1 form-slide-area">


            <div id="filters" class="row"
                 style="">
                <div class="col-md-12">
                    <?= $this->render('_search_organization_translation', ['model' => $searchModel, 'searchEmptyCommand' => $searchEmptyCommand, 'searchNonEmptyCommand' => $searchNonEmptyCommand, 'language_id' => $language_id]) ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <?= $this->render('@backend/views/common/tableHeadSearch.php', ['model' => $searchModel, 'uri' =>Url::to(['organization-translate', 'language_id' => $language_id])]) ?>

                </div>
                <div class="col-md-6">
                    <div class="btn-actions-pane-right actions-icon-btn ">


                    </div>

                </div>
            </div>

            <?= Html::hiddenInput('language_id', $language_id, ['id' => 'language_id', 'data-url' => Yii::$app->urlManager->createUrl('/translatemanager/language/organization-save')]); ?>
            <div id="translates">
                <?php
                Pjax::begin([
                    'id' => 'translates',
                ]);
                $form = ActiveForm::begin([
                    'method' => 'get',
                    'id' => 'search-form',
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => false,
                ]);

                ActiveForm::end();

                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,

                    'id' => 'grid',
                    'tableOptions' => ['class' => AdminThemeHelper::getTableDeleteClass('oreed-table')],
                    'layout' => AdminThemeHelper::getTableLayout($dataProvider),
                    'filterSelector' => 'select[name="per-page"]',
                    'columns' => [
                        [
                            'format' => 'raw',
                            'filter' => Language::getCategories(),
                            'attribute' => 'category',
                            'value' => function ($model) {
                                return GeneralHelpers::formatTableAttribute($model->category)=='Yii'?'Core Messages':GeneralHelpers::formatTableAttribute($model->category);
                            },
                            'filterInputOptions' => ['class' => 'form-control', 'id' => 'category'],
                        ],



                        [
                            'format' => 'raw',
                            'attribute' => 'message',
                            'filterInputOptions' => ['class' => 'form-control', 'id' => 'message'],
                            'contentOptions' => ['style' => 'position: relative;'], // For TD

                            'label' => Yii::t('app', 'Source'),
                            'content' => function ($data) use ($language_id) {
                                if ($language_id == 'EN' && !empty($data->translation))
                                    return Html::textarea('DefaultLanguageTranslate[' . $data->id . ']', $data->translation, ['class' => 'form-control default-translation source', 'data-id' => $data->id, 'tabindex' => $data->id, 'readonly' => 'readonly']);
                                else{
                                    if($language_id == 'EN')
                                        return Html::textarea('LanguageSource[' . $data->id . ']', $data->source, ['class' => 'form-control source', 'readonly' => 'readonly']);

                                    $languageOrgTranslate = OrganizationLanguageTranslate::find()->where(['source_id' => $data->id, 'language' => 'EN','org_id'=>Yii::$app->organization->id])->andWhere(['IS','translation_id',NULL])->one();
                                    if(isset($languageOrgTranslate))
                                        return Html::textarea('LanguageSource[' . $data->id . ']', $languageOrgTranslate->translation, ['class' => 'form-control source', 'readonly' => 'readonly']).'<span class="your-trans-label">'.Yii::t('app','Your Translation').'</span>';
                                    else
                                        return Html::textarea('LanguageSource[' . $data->id . ']', $data->source, ['class' => 'form-control source', 'readonly' => 'readonly']);
                                }
                            },
                        ],


                        [
                            'format' => 'raw',
                            'attribute' => 'default_translation',
                            'filterInputOptions' => [
                                'class' => 'form-control',
                                'id' => 'translation',
                                'placeholder' => $searchEmptyCommand ? Yii::t('app', 'Enter "{command}" to search for empty translations.', ['command' => $searchEmptyCommand]) : '',
                            ],
                            'label' => Yii::t('app', 'Default {lang} Translation', ['lang' => isset($languagesTitles[$language_id]) ? $languagesTitles[$language_id] : '']),
                            'content' => function ($data) {
                                return Html::textarea('DefaultLanguageTranslate[' . $data->id . ']', $data->translation, ['class' => 'form-control default-translation source', 'data-id' => $data->id, 'tabindex' => $data->id, 'readonly' => 'readonly']);
                            },
                            'visible' => $language_id != 'EN'
                        ],
                        [
                            'format' => 'raw',
                            'attribute' => 'translation',
                            'filterInputOptions' => [
                                'class' => 'form-control',
                                'id' => 'translation',
                                'placeholder' => $searchEmptyCommand ? Yii::t('app', 'Enter "{command}" to search for empty translations.', ['command' => $searchEmptyCommand]) : '',
                            ],
                            'label' => Yii::t('app', 'Your Translation'),
                            'content' => function ($data) use ($language_id) {
                                // echo "<pre>";
                                //    print_r($data->orgLanguageTranslates->translation);die;
                                return Html::textarea('LanguageTranslate[' . $data->id . ']', (isset($data->nativeOrgLanguageTranslate)) ? $data->nativeOrgLanguageTranslate->translation : '', ['class' => 'form-control translation', 'data-id' => $data->translationId, 'data-source-id' => $data->id, 'tabindex' => $data->id, 'style' => $language_id == 'AR' ? '    direction: rtl;' : '    direction: ltr;']);
                            },
                        ],
                        [
                            'format' => 'raw',
                            'label' => Yii::t('app', 'Action'),
                            'content' => function ($data) {
                                return Html::button('<i class="fa fa-save"></i> ' . Yii::t('app', 'Save'), ['type' => 'button', 'data-id' => $data->id, 'class' => 'mb-2 me-2 mt-2 btn-hover-shine btn btn-success']);
                            },
                        ],
                    ],
                ]) ?>
                <?php Pjax::end();?>

            </div>


        </div>
    </div>
