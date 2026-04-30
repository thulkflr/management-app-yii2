<?php

use backend\modules\systemdocumentation\services\TourIDs;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this \yii\web\View */
/* @var $listDataProvider yii\data\ActiveDataProvider */
/* @var $sFolder \common\modules\filemanager\models\Folder */

/* @var $showPickIconOnly */
/* @var $searchKeyword */

$breadcrumbSelectedKey = array_key_last($sFolder->breadcrumbs);
$showPickIconOnly = isset($showPickIconOnly) ? $showPickIconOnly : false;

?>
<?php Pjax::begin(['id' => 'pjax-folder-content', 'enablePushState' => false]); ?>
    <div id="<?= TourIDs::GUID_TOUR_BACKEND_FILE_MANAGER_FILE ?>" class="main-card mb-3 card">
        <div class="card-header">
            <i class="header-icon pe-7s-folder icon-gradient bg-happy-fisher"></i>

            <ol class="breadcrumb" style="margin-bottom: 0 !important;">

                <?php if (empty($sFolder->breadcrumbs)): ?>
                    <li class="active breadcrumb-item"><a data-id="<?= $sFolder->id ?>"><?= Yii::t('app', 'Home') ?></a>
                    </li>
                <?php else: ?>
                    <?php foreach ($sFolder->breadcrumbs as $key => $breadcrumb): ?>
                        <li <?= $key == $breadcrumbSelectedKey ? 'class="breadcrumb-item active"' : 'class="breadcrumb-item"' ?>>
                            <a
                                    data-id="<?= $breadcrumb['id'] ?>"><?= (str_contains($breadcrumb['name'], 'Organization_') && !Yii::$app->isMainOrganization)?  Yii::$app->organization->name : $breadcrumb['name'] ?></a></li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ol>
        </div>
        <div class="card-body">
            <input type="hidden" id="selectedFolderID" value="<?= $sFolder->id ?>">


            <div class="file-toolbar bord-btm">
                <div class="btn-file-toolbar">
                    <a data-id="<?= isset($sFolder->breadcrumbs[1]) ? $sFolder->breadcrumbs[1]['id'] : $sFolder->id ?>"
                       class="go-to-home btn btn-icon add-tooltip" href="#"
                       title="Home"
                       data-toggle="tooltip"><i
                                class="fa fa-home"></i></a>
                    <a id="btnRefresh" class="btn btn-icon add-tooltip" href="#" title="Refresh"
                       data-toggle="tooltip"><i
                                class="fa fa-undo"></i></a>
                </div>
                <div class="btn-file-toolbar">
                    <?php if (!$showPickIconOnly): ?>
                        <a id="btnNewFolder" class="btn btn-icon add-tooltip" href="#" title="New Folder"
                           data-toggle="tooltip"><i
                                    class="fa fa-folder"></i></a>
                        <a id="btnRename" class="btn btn-icon add-tooltip" href="#" title="Rename"
                           data-toggle="tooltip">
                           <i class="fa fa-pencil-square"></i>
                       </a>
                        <a id="btnDelete" class="btn btn-icon add-tooltip" href="#" title="Delete"
                           data-toggle="tooltip"><i
                                    class="fa fa-trash"></i></a>
                        <!--            <a id="btnDownload" class="btn btn-icon add-tooltip" href="#" title="Download" data-toggle="tooltip"><i class="fa fa-cloud-download"></i></a>-->
                        <a id="btnBookmarkFolders" class="btn btn-icon add-tooltip" href="#" title="Bookmark"
                           data-toggle="tooltip"><i
                                    class="fa fa-bookmark"></i></a>
                    <?php else : ?>
                        <a id="btnPickSelected" class="btn btn-icon add-tooltip" href="#" title="Pick Selected"
                           data-toggle="tooltip">
                            <i class="fa fa-check-square"></i>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="btn-file-toolbar pull-right" style="padding: 0">
                    <li class="btn-icon add-tooltip" style="padding: 0!important;position: relative" href="#"
                        data-toggle="tooltip">

                        <div class="search-wrapper active ms-3">
                            <div class="input-holder" style="width: 77%">
                                <input id="txtSearchKeyword" class="item search-input" type="search"
                                       placeholder="Type to search"
                                       value="<?= $searchKeyword ?>">
                                <button  id="btnSearch" class="search-icon input-group-addon">
                                    <span style="    top: -5px;"></span>
                                </button>
                            </div>
                        </div>


                        <?php if (0) { ?>
                            <div class="input-group">
                                <input id="txtSearchKeyword" class="item form-control" type="search"
                                       placeholder="Type to search"
                                       value="<?= $searchKeyword ?>">
                                <span id="btnSearch" class="input-group-addon">
                        <i class="fa fa-search"></i>
                    </span>
                            </div>
                        <?php } ?>
                    </li>
                </div>
            </div>


            <div id="demo-mail-list" class="file-list">
                <?php if (count($sFolder->breadcrumbs) > 2): ?>
                    <div class="file-folder-item back"
                         data-id="<?= $sFolder->breadcrumbs[$breadcrumbSelectedKey - 1]['id'] ?>">
                        <div class="file-attach-icon"></div>
                        <a href="#" class="file-details">
                            <div class="media-block">
                                <div class="media-left"><i class="fa fa-folder"></i></div>
                                <div class="media-body">
                                    <p class="file-name single-line"><?= Yii::t('app', 'go back') ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endif; ?>
                <?= ListView::widget([
                    'dataProvider' => $listDataProvider,
                    'layout' => "{pager}\n{items}",
                    'itemView' => '_folder_file_view',
                    'emptyText' => Yii::t('app', 'Folder is Empty'),
                    'pager' => [
                        'maxButtonCount' => 2,
                    ],
                ]);
                ?>
            </div>

        </div>
    </div>


<?php
$this->registerJs('
$(document).on("pjax:success", function() {
      $("[data-toggle=\'toggle\']").bootstrapToggle(\'destroy\')
    $("[data-toggle=\'toggle\']").bootstrapToggle();
});
    $(".breadcrumb-item a").click(function (e) {
    e.preventDefault();
    var id = $(this).data("id");
    $(`div[data-id="${id}"]`).trigger("dblclick");
    })
')
?>
    <style>
        .pagination {
            margin-bottom: 0 !important;
            margin-top: 10px !important;
        }
    </style>
<?php Pjax::end() ?>