<?php
/**
 * @author Lajos Molnár <lajax.m@gmail.com>
 *
 * @since 1.4
 */

/* @var $this \yii\web\View */
/* @var $newDataProvider \yii\data\ArrayDataProvider */

use yii\grid\GridView;
use backend\helpers\AdminThemeHelper;

?>
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">
                <i class="header-icon lnr-list icon-gradient bg-happy-fisher"></i>
                <?= Yii::t('app','New Translatable Items') ?>
            </div>
            <div class="card-body">
                    <?=
                    GridView::widget([
                        'id' => 'added-source',
                        'tableOptions' => ['class' => AdminThemeHelper::getTableDeleteClass()],
                        'layout' => AdminThemeHelper::getTableLayout($newDataProvider),
                        'filterSelector' => 'select[name="per-page"]',
                        'dataProvider' => $newDataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'category',
                            'message',
                        ],
                    ]);

                    ?>
            </div>
        </div>
    </div>
</div>






