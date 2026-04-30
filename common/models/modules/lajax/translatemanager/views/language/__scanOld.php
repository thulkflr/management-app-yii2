<?php
/**
 * @author Lajos Molnár <lajax.m@gmail.com>
 *
 * @since 1.4
 */
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use backend\helpers\AdminThemeHelper;

/* @var $this \yii\web\View */
/* @var $oldDataProvider \yii\data\ArrayDataProvider */

?>

    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-header">
                    <i class="header-icon lnr-list icon-gradient bg-happy-fisher"></i>
                    <?= Yii::t('app','Old Translatable Items') ?>
                    <div class="btn-actions-pane-right actions-icon-btn">
                        <?php if ($oldDataProvider->totalCount > 1) : ?>

                            <?= Html::button(Yii::t('app', 'Select all'), ['id' => 'select-all', 'class' => 'btn btn-primary']) ?>

                            <?= Html::button(Yii::t('app', 'Delete selected'), ['id' => 'delete-selected', 'class' => 'btn btn-danger']) ?>

                        <?php endif ?>
                    </div>
                </div>
                <div class="card-body">
                        <?= GridView::widget([
                            'id' => 'delete-source',
                            'tableOptions' => ['class' => AdminThemeHelper::getTableDeleteClass()],
                            'layout' => AdminThemeHelper::getTableLayout($oldDataProvider),
                            'filterSelector' => 'select[name="per-page"]',
                            'dataProvider' => $oldDataProvider,
                            'columns' => [
                                [
                                    'format' => 'raw',
                                    'attribute' => '#',
                                    'content' => function ($languageSource) {
                                        return Html::checkbox('LanguageSource[]', false, ['value' => $languageSource['id'], 'class' => 'language-source-cb']);
                                    },
                                ],
                                'id',
                                'category',
                                'message',
                                'languages',
                                [
                                    'format' => 'raw',
                                    'attribute' => Yii::t('app', 'Action'),
                                    'content' => function ($languageSource) {
                                        return Html::a(Yii::t('app', 'Delete'), Url::toRoute('/translatemanager/language/delete-source'), ['data-id' => $languageSource['id'], 'class' => 'delete-item btn btn-xs btn-danger']);
                                    },
                                ],
                            ],
                        ]);

                        ?>
                </div>
            </div>
        </div>
    </div>


