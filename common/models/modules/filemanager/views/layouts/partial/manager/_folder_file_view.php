<?php

use common\helpers\General;
use common\modules\filemanager\models\File;

/** @var $model */
$dataInputID = "file_folder_item_{$model['item_id']}_{$model['item_type']}";
$dataInputName = "file_folder_item_[{$model['item_type']}][{$model['item_id']}]";
?>

<div class="file-folder-item"
     for="<?= $dataInputID ?>" <?= $model['item_type'] == 1 ? ('data-path="' . $model['path'] . '"') : '' ?>
     data-id="<?= $model['item_id'] ?>" data-type-id="<?= $model['item_type'] ?>">
    <div class="file-control">
        <input id="<?= $dataInputID ?>" name="<?= $dataInputName ?>" value="<?= $dataInputID ?>"
               class="toggle-checkbox"
               data-onstyle='success' data-toggle='toggle' data-size='small'
               data-on='<i class="lnr-checkmark-circle checkbox-icon check"></i>' data-off=' '
               type="checkbox">
        <label for="<?= $dataInputID ?>"></label>
    </div>
    <div class="file-settings"><a href="#"><i class="pci-ver-dots"></i></a></div>
    <div class="file-attach-icon"></div>
    <a href="#" class="file-details">
        <div class="media-block">
            <div class="media-left">
                <?php $file = $model['item_type'] == 1 ? File::findOne($model['item_id']) : null; ?>
                <?php if ($file != null && $file->getFileThumbnail(75) != null): ?>
                    <img class="file-thumbnail" src="<?= $file->getFileThumbnail(75) ?>">
                <?php else: ?>
                    <i class="fa <?= File::getFileIconByExtension($model['item_type'] == 0 ? 'folder' : $model['extension']) ?>"></i>
                <?php endif ?>
            </div>
            <div class="media-body">
                <p class="file-name"><?= $model['alias'] ?></p>
                <small>
                    <?= Yii::t('app', 'Created') . ' ' . $model['created_at'] ?>
                    <?php //General::getFolderSize(Yii::getAlias(str_replace('/cdn', '@cdn', $model['path']))) ?>
                </small>
            </div>
        </div>
    </a>
</div>