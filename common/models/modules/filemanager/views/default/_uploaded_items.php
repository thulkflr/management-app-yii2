<?php

use yii\helpers\Url;
use common\modules\filemanager\models\ModelRelatedFile;
use yii\widgets\Pjax;

/** @var $modelClass */
/** @var $modelAttribute */
/** @var $uploadFolderID */
/** @var $selectedItems */
/** @var $multiple */
/** @var $accept */

$relatedFiles = ModelRelatedFile::getRelatedFiles($modelClass, $modelAttribute, [], $uploadFolderID, $accept, 20, $org_id);
?>

<?php Pjax::begin(['id' => 'pjax-uploaded-items-content', 'enablePushState' => false]); ?>
    <table class="table">
        <tr>
            <td style="vertical-align: middle; <?= Yii::$app->id != 'app-backend' ? 'border:0' : '' ?>">
                <?php if ($multiple): ?>
                    <a href="#" class="action-select-all btn btn-info" mode="select">
                        <i class="lnr-checkmark-circle fa fa-check-square-o"></i>
                        <?= Yii::t('app', 'Select All') ?>
                    </a>
                <?php endif; ?>
                <a href="#" class="action-upload btn btn-warning">
                    <i class="pe-7s-upload fa fa-cloud-upload"></i>
                    <?= Yii::t('app', 'Upload Files') ?>
                </a>
                <?php if ($multiple == true): ?>
                    <a href="#" class="action-pick btn btn-primary">
                        <i class="lnr-pointer-up fa fa-check"></i>
                        <?= Yii::t('app', 'Pick Selected') ?>
                    </a>
                <?php endif; ?>
                <a href="#" class="action-delete btn btn-danger">
                    <i class="fa fa-trash"></i>
                    <?= Yii::t('app', 'Deleted Selected') ?>
                </a>
            </td>
        </tr>
    </table>

    <table class="table table-hover uploaded-items-list">
        <tbody>
        <?php if (count($relatedFiles) == 0): ?>
            <tr>
                <td colspan="4"><i style="font-size: 13px;"><?= Yii::t('app', 'No files was uploaded') ?></i></td>
            </tr>
        <?php else: ?>
            <?php foreach ($relatedFiles as $rfile): ?>
                <?php $isImageFile = strpos($rfile->file->mim_type, 'image') !== false || strpos($rfile->file->mim_type, 'video') !== false || strpos($rfile->file->mim_type, 'pdf') !== false; ?>
                <?php
                $dimensions = '';
                if ($isImageFile) {
                    $size = $rfile->file->getDimensions();
                    $dimensions = !empty($size) ? "data-image-dimensions='{$size['width']}:{$size['height']}'" : '';
                }
                ?>
                <tr data-id="<?= $rfile->id ?>" data-mim-type="<?= $rfile->file->mim_type ?>" <?= $dimensions ?>>
                    <td>
                        <input type="checkbox"
                               value="<?= $rfile->id ?>"
                            <?= in_array($rfile->id, $selectedItems) ? 'checked' : '' ?>>
                    </td>
                    <td style="width: 7%">
                        <?php if ($isImageFile): ?>
                            <img class="item" src="<?= $rfile->file->getFileThumbnail(75) ?>">
                        <?php else : ?>
                            <i class=" ?php File::getFileIconByExtension($rfile->file->extension) ?><!--"></i>
                        <?php endif; ?>
                    </td>
                    <td style="width: 83%">
                        <a href="<?= $rfile->file->path ?>" style="word-break: break-all;" target="_blank" data-pjax="0"><?= $rfile->file->alias ?></a>
                    </td>
                    <td style="width: 10%; text-align: right">
                        <?php if ($multiple == false): ?>
                            <a
                                    title="<?= Yii::t('app', 'Pick') ?>"
                                    class="btn btn-primary btn-sm pick-selected-file file-<?= $rfile->id ?>"
                                    data-id="<?= $rfile->id ?>"
                                    href="#">
                                <i style="font-size: 12px" class="fa fa-check"></i>
                            </a>
                        <?php endif; ?>
                        <a title="<?= Yii::t('app', 'Remove') ?>"
                           class="btn btn-danger btn-sm  remove-selected-file file-<?= $rfile->id ?>"
                           data-id="<?= $rfile->id ?>"
                           href="<?= Url::to(['/file-manager/default/remove-selected-file', 'id' => $rfile->id]) ?>">
                            <i style="font-size: 12px" class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
<?php Pjax::end() ?>