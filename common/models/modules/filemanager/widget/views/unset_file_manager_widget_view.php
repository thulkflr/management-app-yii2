<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\modules\filemanager\assets\BackendFileManagerWidgetAssets;
use common\modules\filemanager\assets\FrontendFileManagerWidgetAssets;
use common\modules\filemanager\models\File;
use common\modules\filemanager\models\ModelRelatedFile;

/** @var $this \yii\web\View */
/** @var $model */
/** @var $attribute */
/** @var $value */
/** @var $folder_id */
/** @var $multiple */
/** @var $aspect_ratio */
/** @var $tag */
/** @var $preview_selected */
/** @var $overwrite_current_image */
/** @var $accept */
/** @var $as_array */
/** @var $dynamic_form_container */
/** @var $after_select */

if (Yii::$app->id == 'app-backend') {
    BackendFileManagerWidgetAssets::register($this);
} else {
    FrontendFileManagerWidgetAssets::register($this);
}

$filedId = uniqid("fm_filed_{$attribute}_");
$valueToString = is_array($value) ? implode(',', $value) : $value;
$valueToString = ($valueToString == '0') ? '' : $valueToString;

$valueToArray = explode(',', $valueToString);
$labelName = count($valueToArray) > 1 ? Yii::t('app', '{count} Files Selected', ['count' => count($valueToArray)]) : File::find()->alias('file')->select(['alias'])->innerJoin('{{%model_related_file}} mrf', 'mrf.file_id = file.id')->where(['mrf.id' => $valueToArray[0]])->createCommand()->queryScalar();

$attributeName = $attribute;
$attribute = strpos($attribute, ']') !== false ? substr($attribute, (strpos($attribute, ']') + 1), strlen($attribute)) : $attribute;
$as_array = (int)(strpos($attributeName, ']') !== false);

$index = $model->primaryKey > 0 ? $model->primaryKey : (uniqid(rand(0, 99999) . '_'));
?>
    <div class="fm-filed">
        <div class="input-group widget-upload-input">
            <?= Html::textInput("{$filedId}_label", $labelName, ['id' => "{$filedId}_label", 'class' => 'form-control', 'disabled' => true]) ?>
            <?= Html::activeHiddenInput($model, $attributeName, ['value' => $valueToString, 'class' => 'form-control']) ?>
            <span class=" delete-selected-file text-danger input-group-addon " style="border-radius: 0 !important;">
            <i class="lnr-cross-circle fa fa-close fas fa-times"></i>
        </span>
            <span class="input-group-addon unset-pick">
            <i class="fa fa-folder"></i>
        </span>

        </div>
        <?php if ($preview_selected): ?>
            <div class="file-manager-input-selections">
                <table class="table table-hover">
                    <tbody>
                    <?php $relatedFiles = ModelRelatedFile::getRelatedFiles($model::className(), $attribute, $valueToArray,null,null,null, $org_id); ?>
                    <?php foreach ($relatedFiles as $rfile): ?>
                        <?php $isImageFile = strpos($rfile->file->mim_type, 'image') !== false || strpos($rfile->file->mim_type, 'video') !== false || strpos($rfile->file->mim_type, 'pdf') !== false; ?>
                        <tr>
                            <td style="width: 5%">
                                <?php if ($isImageFile): ?>
                                    <img class="item" src="<?= $rfile->file->getFileThumbnail(75) ?>">
                                <?php else : ?>
                                    <i class="
                                <?php File::getFileIconByExtension($rfile->file->extension) ?><!--"></i>
                                <?php endif; ?>
                            </td>
                            <?php if (true || !$as_array): ?>
                                <td style="width: 95%">
                                    <a data-pjax="0" href="<?= $rfile->file->path ?>"
                                       target="_blank"><?= $rfile->file->alias ?></a>
                                </td>
                                <td style="width: 2%">

                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <div id="modal_<?= $filedId ?>" class="fade modal file-manager-widget-modal" role="dialog" tabindex="-1">
        <div class="modal-dialog" style="width: 70%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 id="modalTitle"></h3>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
<style>
    .widget-upload-input>input, .widget-upload-input>.input-group-addon.unset-pick {
        height: 34px;
    }


    .input-group-addon.unset-pick {
        padding: 8px;
        border: 1px solid #ced4da;
    }
    .input-group-addon.unset-pick {
        padding-top: 6px;
    }
</style>
