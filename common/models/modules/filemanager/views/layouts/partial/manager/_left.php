<?php

use backend\modules\systemdocumentation\services\TourIDs;
use yii\widgets\Pjax;
use yii\helpers\Html;
use common\modules\filemanager\models\BookmarkFolder;
use common\modules\filemanager\models\FileManagerTag;
use Yii;

/* @var $orgUsedSize */
/* @var $orgStorageSize */

$bookmarkedFolders = BookmarkFolder::getUserBookmarkedFolders();
$tagsList = FileManagerTag::getTagsList(10);
$orgUsedSize =(float)round(($orgUsedSize / 1000000),2)         ;
$orgUsedSizePercentage = $orgStorageSize > 0 ? ($orgUsedSize / $orgStorageSize) * 100 : 100;

$progressColor = $orgUsedSizePercentage <= 50 ? 'progress-bar-primary' : ($orgUsedSizePercentage <= 70 ? 'progress-bar-warning' : 'progress-bar-danger');
?>
<?php Pjax::begin(['id' => 'pjax-manager-left-list', 'enablePushState' => false]); ?>
    <div id="<?= TourIDs::GUID_TOUR_BACKEND_FILE_MANAGER_OPTIONS ?>" class="main-card mb-3 card">
        <div class="card-header">
            <i class="header-icon  lnr-cog icon-gradient bg-happy-fisher"></i>
            <?= Yii::t('app', 'Options') ?>
        </div>
        <div class="card-body">
            <div class="row-container">
                <div class="action">
                    <?= Html::button(Yii::t('app', 'Upload Files'), ['class' => 'btn btn-upload-files']) ?>
                </div>
                <div class="bookmarked -list">
                    <p class="header-title"><?= Yii::t('app', 'Storage') ?></p>
                    <div class="list-group bg-trans pad-ver bord-btm storage-progress">
                        <a href="#" class="list-group-item">

                            <div class="mb-3 progress-bar-animated-alt progress">
                                <div class="progress-bar <?= $progressColor ?>" role="progressbar"
                                     aria-valuenow="<?= 50 ?>" aria-valuemin="0" aria-valuemax="100"
                                     style="width: <?= $orgUsedSizePercentage ?>%;">
                                    <?php //$orgUsedSizePercentage% ?>
                                </div>
                            </div>


                            <?= Yii::t('app', '{usedSize} GB Of {storageSize} GB Used', ['usedSize' => $orgUsedSize, 'storageSize' => $orgStorageSize]) ?>
                        </a>
<!--                        <a href="#" class="list-group-item btn btn-primary btn-buy-storage">--><?php //Yii::t('app', 'Buy Storage') ?><!--</a>-->
                    </div>
                </div>
                <div class="bookmarked -list">
                    <p class="header-title"><?= Yii::t('app', 'Bookmarked') ?></p>
                    <div class="list-group bg-trans pad-ver">
                        <?php if (count($bookmarkedFolders) == 0): ?>
                            <a class="list-group-item"><?= Yii::t('app', 'No folders was bookmarked') ?></a>
                        <?php else : ?>
                            <?php foreach ($bookmarkedFolders as $folder): ?>
                                <?php $refFolder = $folder->folder ?>
                                <a data-id="<?= $folder->folder_id ?>" href="#"
                                   class="list-group-item bookmarked-folder-item">
                                    <i class="fa fa-folder"></i>
                                    <span class="folder-name"><?= $refFolder->alias ?></span>
                                    <i data-id="<?= $folder->id ?>" title="<?= Yii::t('app', 'Remove') ?>"
                                       class="fa fa-trash pull-right"></i>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!--        <div class="folders-list">-->
                <!--            <p class="header-title">--><?php //= Yii::t('app', 'Folders') ?><!--</p>-->
                <!--            <div class="list-group bg-trans pad-ver bord-btm">-->
                <!--                <a href="#" class="list-group-item active"><i class="fa fa-folder"></i> Documents</a>-->
                <!--                <a href="#" class="list-group-item"><i class="fa fa-folder"></i> PDF</a>-->
                <!--                <a href="#" class="list-group-item"><i class="fa fa-folder"></i> Images</a>-->
                <!--                <a href="#" class="list-group-item"><i class="fa fa-folder"></i> Classes</a>-->
                <!--                <a href="#" class="list-group-item"><i class="fa fa-folder"></i> Activities</a>-->
                <!--            </div>-->
                <!--        </div>-->
            </div>

        </div>
    </div>
<?php Pjax::end() ?>