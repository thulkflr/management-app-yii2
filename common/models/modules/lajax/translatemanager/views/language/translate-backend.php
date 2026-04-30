<?php

/**
 * @author Lajos Molnár <lajax.m@gmail.com>
 *
 * @since 1.0
 */
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView; 
use backend\widgets\ActiveForm;
use common\modules\lajax\translatemanager\helpers\Language;
use common\modules\lajax\translatemanager\models\Language as Lang;
use yii\helpers\Url;
use common\components\GeneralHelpers;
use backend\helpers\AdminThemeHelper;

/* @var $this \yii\web\View */
/* @var $language_id string */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \common\modules\lajax\translatemanager\models\searches\LanguageSourceSearch */
/* @var $searchEmptyCommand string */

$this->context->pageTitleIcon = 'lnr-text-size';
$this->context->backText= Yii::t('app', 'Back To Languages');
$this->context->backlink=Url::to(['list']);



$this->title = Yii::t('app', 'Admin Translation For {language_id}', ['language_id' => $language_id]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Organizations Setup'), 'url' => ['/site/menu-page','type'=>'organizations_setup']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Languages'), 'url' => ['list-backend']];
$this->params['breadcrumbs'][] = $this->title;
$isPublicSearch = Yii::$app->request->get($searchModel->formName()) && count(Yii::$app->request->get($searchModel->formName())) == 1 && isset(Yii::$app->request->get($searchModel->formName())['tablePublicSearch']);

?>

    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">
                    <i class="header-icon lnr-list icon-gradient bg-happy-fisher"></i>
                    <?= $this->title ?>
                    <?= $this->render('@backend/views/common/tableHeadSearch.php', ['model' => $searchModel, 'uri' => Url::to(['translate-backend','language_id'=>$language_id])]) ?>
                    <div class="btn-actions-pane-right actions-icon-btn">
                        <a href="<?= Url::to(['/translatemanager/language/save']) ?>"
                           class="mb-2 mt-2 me-2 btn btn-outline-primary btn-translation-modal ">
                            <i class="pe-7s-plus btn-icon-wrapper"></i> <?= Yii::t('app', 'Create Source') ?>
                        </a>

                        <?= AdminThemeHelper::getFilterIcon() ?>
                    </div>
                </div>
                <div class="card-body">
                    <div id="filters" class="row"
                         style="display:<?= !$isPublicSearch && Yii::$app->request->get($searchModel->formName()) ? '' : 'none' ?>">
                        <div class="col-md-12">
                            <?= $this->render('_search_backend_translation', ['model' => $searchModel, 'searchEmptyCommand' => $searchEmptyCommand, 'searchNonEmptyCommand' => $searchNonEmptyCommand,'language_id'=>$language_id]) ?>
                        </div>
                    </div>
                    <div class="translation-index box box-primary">
                        <?= Html::hiddenInput('language_id', $language_id, ['id' => 'language_id', 'data-url' => Yii::$app->urlManager->createUrl('/translatemanager/language/save')]); ?>
                        <div id="translates" >

                            <a href="#"
                               class="mb-2 mt-3 btn btn-outline-primary  " id="translate-by-ai">
                                <i class="pe-7s-plus btn-icon-wrapper"></i> <?= Yii::t('app', 'AI Translator') ?>
                            </a>
                            <span id="wait-translate" style="display: none"><i class="fa fa-spinner fa-spin"></i> Your Translation will be added soon please wait
                            </span>

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
                                'id' => 'grid',
                                'tableOptions' => ['class' => AdminThemeHelper::getTableDeleteClass()],
                                'layout' => AdminThemeHelper::getTableLayout($dataProvider),
                                'filterSelector' => 'select[name="per-page"]',
                                'columns' => [
                                    [
                                        'format' => 'raw',
                                        'filter' => Language::getCategories(),
                                        'attribute' => 'category',
                                        'value' => function ($model) {
                                            return GeneralHelpers::formatTableAttribute($model->category);
                                        },
                                        'filterInputOptions' => ['class' => 'form-control', 'id' => 'category'],
                                    ],
                                    [
                                        'format' => 'raw',
                                        'attribute' => 'message',
                                        'filterInputOptions' => ['class' => 'form-control', 'id' => 'message'],
                                        'label' => Yii::t('app', 'Source'),
                                        'content' => function ($data) {
                                            return Html::textarea('LanguageSource[' . $data->id . ']', $data->source, ['class' => 'form-control source', 'readonly' => 'readonly']);
                                        },
                                    ],
                                    [
                                        'format' => 'raw',
                                        'attribute' => 'translation',
                                        'filterInputOptions' => [
                                            'class' => 'form-control',
                                            'id' => 'translation',
                                            'placeholder' => $searchEmptyCommand ? Yii::t('app', 'Enter "{command}" to search for empty translations.', ['command' => $searchEmptyCommand]) : '',
                                        ],
                                        'label' => Yii::t('app', 'Translation'),
                                        'content' => function ($data) use ($language_id) {
                                            return Html::textarea('LanguageTranslate[' . $data->id . ']', $data->translation, ['class' => 'form-control translation', 'data-id' => $data->id, 'tabindex' => $data->id, 'style' => $language_id == 'AR' ? '    direction: rtl;' : '    direction: ltr;']);
                                        },
                                    ],
                                    [
                                        'format' => 'raw',
                                        'label' => Yii::t('app', 'Action'),
                                        'headerOptions' => ['class' => 'small-input'],
                                        'content' => function ($data, $key, $index, $column) {
                                            // return Html::button(Yii::t('app', 'Save'), ['type' => 'button', 'data-id' => $data->id, 'class' => 'btn btn-lg btn-success margin-right-15']) .
                                            //        Html::tag('a', Html::encode(Yii::t('app', 'Update Source')), ['class'=>'btn btn-lg btn-primary btn-translation-modal', 'data-id' => $data->id]);'class' => 'btn btn-table btn-default',
                                            return Html::button('<i class="fa fa-save"></i> ' . Yii::t('app', 'Save'), ['type' => 'button', 'data-id' => $data->id, 'class' => 'mb-2 me-2 mt-2 btn-hover-shine btn btn-success save-translate-'.$index]);
                                        },
                                    ],
                                ],
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
<?php if(0){ ?>
    <div class="translation-index box box-primary">
    <?= Html::hiddenInput('language_id', $language_id, ['id' => 'language_id', 'data-url' => Yii::$app->urlManager->createUrl('/translatemanager/language/save')]); ?>
    <?=  Html::tag('a', Html::encode(Yii::t('app', 'Create Source')), ['class'=>'btn btn-primary btn-translation-modal float-right margin_bottom_10']); ?>

<div id="translates" class="<?= $language_id ?>">
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
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'format' => 'raw',
                'filter' => Language::getCategories(),
                'attribute' => 'category',
                'value' => function ($model) {
                    return GeneralHelpers::formatTableAttribute($model->category);
                },
                'filterInputOptions' => ['class' => 'form-control', 'id' => 'category'],
            ],
            [
                'format' => 'raw',
                'attribute' => 'message',
                'filterInputOptions' => ['class' => 'form-control', 'id' => 'message'],
                'label' => Yii::t('app', 'Source'),
                'content' => function ($data) {
                    return Html::textarea('LanguageSource[' . $data->id . ']', $data->source, ['class' => 'form-control source', 'readonly' => 'readonly']);
                },
            ],
            [
                'format' => 'raw',
                'attribute' => 'translation',
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'id' => 'translation',
                    'placeholder' => $searchEmptyCommand ? Yii::t('app', 'Enter "{command}" to search for empty translations.', ['command' => $searchEmptyCommand]) : '',
                ],
                'label' => Yii::t('app', 'Translation'),
                'content' => function ($data) use ($language_id){
                    return Html::textarea('LanguageTranslate[' . $data->id . ']', $data->translation, ['class' => 'form-control translation', 'data-id' => $data->id, 'tabindex' => $data->id,'style'=>$language_id=='AR'?'    direction: rtl;':'    direction: ltr;']);
                },
            ],
            [
                'format' => 'raw',
                'label' => Yii::t('app', 'Action'),
                'headerOptions' => ['class' => 'small-input'],
                'content' => function ($data) {
                    // return Html::button(Yii::t('app', 'Save'), ['type' => 'button', 'data-id' => $data->id, 'class' => 'btn btn-lg btn-success margin-right-15']) .
                    //        Html::tag('a', Html::encode(Yii::t('app', 'Update Source')), ['class'=>'btn btn-lg btn-primary btn-translation-modal', 'data-id' => $data->id]);'class' => 'btn btn-table btn-default',
                    return Html::button('<i class="fa fa-save"></i> ' .Yii::t('app', 'Save'), ['type' => 'button', 'data-id' => $data->id, 'class' => 'btn btn-lg btn-default margin-right-15']);
                },
            ],
        ],
        'summaryOptions' => ['class' => 'margin_bottom_10'],
    ]);
    Pjax::end();
    ?>

</div>
</div>
<?php } ?>


<?php  $this->registerJS("
$(document).on('click', '.btn-translation-modal', function(e){
    e.preventDefault();
    let id = $(this).data('id') ? $(this).data('id') : 0;
    let sourceModalTitle = id ? '".Yii::t('app', 'Update Source')."' : '".Yii::t('app', 'Create Source')."';
    $('#gModal').find('#modalTitle').html(sourceModalTitle);
    $('#gModal').find('.modal-body').load('".Url::to(['/translatemanager/language/source-form-handler?id='])."'+id, function () {
        $('#gModal').modal('show');
    });
});
$(document).on('click', '#translate-by-ai', function(e){
    e.preventDefault();
    $('#wait-translate').css('display', 'inline');
    $('.form-control.translation').attr('disabled', true)
    let values = [];
    $('.form-control.source').each(function () {
        values.push($(this).val()); // get value and push into array
    });
    console.log(values);
    $.ajax({
          url: '". Url::to(['translate-ai','language_id'=>Yii::$app->request->get('language_id')]) ."',
          type: 'POST',
          data: {
            _csrf: $('meta[name=\"csrf-token\"]').attr('content'),
            values: values // becomes values[] on the server
          },
          success: function(res) {
              if (res.ok) {
                  $('.form-control.translation').each(function (i) {
                
                    if (res.translations[i] !== undefined) {
                     var translation = res.translations[i];
                        var el = $(this); // capture the element
                
                        setTimeout(function () {
                            el.val(translation);
                            el.prop('disabled', false); // shorter for attr
                            $('.save-translate-'+i).trigger('click'); // shorter for attr
                        }, i * 1000); // delay i seconds for each
                    }
                  });
                  $('#wait-translate').css('display', 'none');
              
                   
              }
              
          },
          error: function(xhr) {
            console.error('Error:', xhr.responseText);
          }
    });
});
");
?>