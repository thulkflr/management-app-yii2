<?php

use common\modules\filemanager\src\FileUploadUI;
use common\modules\filemanager\assets\UploaderUIAssets;
use multitenant\handlers\Config;
use multitenant\handlers\Constants;

UploaderUIAssets::register($this);

/** @var $this \yii\web\View */

/** @var $listDataProvider */
/** @var $sFolder */
/** @var $showPickIconOnly */
/** @var $uploadFolderID */
/** @var $modelClass */
/** @var $attribute */
/** @var $tag */
/** @var $accept */


$selectorDataAttributes = '';
foreach ($_REQUEST as $key => $value) {
    $selectorDataAttributes .= "data-{$key} = '{$value}' ";
}

$fileUploaderOptions = ['multiple' => true];
if (!empty($accept)) {
    $fileUploaderOptions['accept'] = $accept;
}

$selectedItems = isset($_REQUEST['selectedItems']) ? explode(',', $_REQUEST['selectedItems']) : [];
$selectedItems = isset($_REQUEST['selecteditems']) ? explode(',', $_REQUEST['selecteditems']) : $selectedItems;
$model_id = isset($_REQUEST['index']) ? $_REQUEST['index'] : 0;
$model_id = strpos($model_id, '_') !== false ? 0 : (int)($model_id);

if(Yii::$app->id=='app-frontend') {
    if (!Yii::$app->user->isGuest) {
        Yii::$app->language = isset(Yii::$app->user->identity->language) ? Yii::$app->user->identity->language->code : null;

        $availableLanguages=[];
        foreach (Yii::$app->organization->organizationLanguage as $language) {
            $availableLanguages[$language->lang->code] = $language->lang->code;
        }
        if( !in_array(Yii::$app->language,$availableLanguages) ){
            Yii::$app->language=null;
        }

        if (is_null(Yii::$app->language)) {
            if (Yii::$app->isMainOrganization)
                Yii::$app->language= 'AR';
            else
                Yii::$app->language= isset(Yii::$app->organization->orgBasicSetting->defaultLang) ? Yii::$app->organization->orgBasicSetting->defaultLang->code : 'en';
        }
    } else {
        if (Yii::$app->request->cookies->has('public-select-language-' . Yii::$app->organization->id))
            Yii::$app->language= Yii::$app->request->cookies->getValue('public-select-language-' . Yii::$app->organization->id);
        else {
            if (Yii::$app->isMainOrganization)
                Yii::$app->language = 'AR';
            else
                Yii::$app->language = isset(Yii::$app->organization->orgBasicSetting->defaultLang) ? Yii::$app->organization->orgBasicSetting->defaultLang->code : 'en';

        }
    }
}

?>
<?php if (!empty($_REQUEST['aspectRatio']) || !empty($_REQUEST['accept']) || !empty($_REQUEST['uploadLimitValue'])): ?>
    <div class="vma-alert-block-transparent vma-alert-block-transparent--blue alert alert-light fade show" role="alert" style="
">
        <i class="pe-7s-attention"></i>
        <?php if (!empty($_REQUEST['aspectRatio'])): ?>
            * <?= Yii::t('app', 'The file must have {ratio} aspect ratio', ['ratio' => $_REQUEST['aspectRatio']]) ?>
            <br>
        <?php endif; ?>
<!--        --><?php //if (!empty($_REQUEST['aspectRatio'])&&!empty($_REQUEST['accept'])): ?>
<!--            <br>-->
<!--        --><?php //endif; ?>
        <?php if (!empty($_REQUEST['accept'])): ?>
            * <?= Yii::t('app', 'File types accepted: {types}', ['types' => $_REQUEST['accept']]) ?>
            <br>
        <?php endif; ?>
 <?php if (!empty($_REQUEST['uploadLimitValue'])): ?>
            * <?= Yii::t('app', 'Upload Limit Size: {limit} MB', ['limit' => $_REQUEST['uploadLimitValue'] ]) ?>
     <br>
        <?php endif; ?>


    </div>


<?php endif; ?>
<div class="alert alert-danger" id="error-load" style="display: none"></div>
<div class="nav-tabs-custom selector" <?= $selectorDataAttributes ?>>
    <?php if (Yii::$app->id == 'app-backend'): ?>
        <ul class="nav nav-tabs">
            <li class="nav-item active">
                <a data-href="#fileManagerUploadedItems" href="#"
                   class="nav-link file-manager-nav-link file-uploader-tabs active" data-toggle="tab"
                   aria-expanded="true">
                    <?= Yii::t('app', 'Related Files') ?>
                </a>
            </li>
            <li class="nav-item">
                <a data-href="#fileManagerFilesOnDesk" href="#"
                   class="nav-link file-manager-nav-link file-uploader-tabs" data-toggle="tab"
                   aria-expanded="false">
                    <?= Yii::t('app', 'Files on Desk') ?>
                </a>
            </li>
        </ul>

    <?php endif; ?>
    <div class="<?= (Yii::$app->id == 'app-backend') ? 'tab-content' : '' ?>">
        <div class="tab-pane file-manager-tab-pane active" id="fileManagerUploadedItems" role="tabpanel">
            <?= $this->render('_uploaded_items', [
                'modelClass' => isset($_REQUEST['model']) ? $_REQUEST['model'] : '',
                'modelAttribute' => isset($_REQUEST['attribute']) ? $_REQUEST['attribute'] : '',
                'uploadFolderID' => $uploadFolderID,
                'selectedItems' => $selectedItems,
                'multiple' => isset($_REQUEST['multiple']) ? (boolean)($_REQUEST['multiple']) : false,
                'accept' => $accept,
                'org_id' => $org_id,
            ]) ?>
        </div>
        <?php if (Yii::$app->id == 'app-backend'): ?>
            <div class="<?= (Yii::$app->id == 'app-backend') ? 'tab-pane file-manager-tab-pane' : '' ?>"
                 role="tabpanel" id="fileManagerFilesOnDesk">
                <?= $this->render('../layouts/partial/manager/_center', [
                    'listDataProvider' => $listDataProvider,
                    'sFolder' => $sFolder,
                    'searchKeyword' => $searchKeyword,
                    'showPickIconOnly' => $showPickIconOnly
                ]) ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="crop-container" style="display: none">
    <div class="image-container">

    </div>
    <div class="actions">
        <a class="btn btn-primary"><?= Yii::t('app', 'Crop') ?></a>
        <a class="btn btn-danger"><?= Yii::t('app', 'Cancel') ?></a>
    </div>
</div>

<div class="uploader-container" style="display: none">
    <button class="btn btn-default back-to-uploaded-list">
        <i class="fa fa-arrow-left"></i>&nbsp;&nbsp;<?= Yii::t('app', 'Back to Uploaded List') ?>
    </button>
    <hr style="border-color: #cccccc;margin-top: 7px;margin-bottom: 7px;"/>
    <?= FileUploadUI::widget(['uploadTemplateId' => 'templateUpload',
        'downloadTemplateId' => 'templateDownload',
        'model' => new \common\modules\filemanager\models\File(),
        'attribute' => 'file_object',
        'url' => Config::get(Constants::UNI_UPLOAD_URL).\yii\helpers\Url::to(['default/upload', 'folder_id' => $uploadFolderID, 'model_class' => $modelClass, 'model_id' => $model_id, 'attribute' => $attribute, 'tag' => $tag, 'org_id' => $org_id, 'accept' => $accept,'t'=>Yii::$app->organization->getUploadToken(true),'alt'=>$_REQUEST['uploadLimitType']]),
        'gallery' => false,
        'fieldOptions' => $fileUploaderOptions,
        'clientEvents' => [
            'fileuploadadd' => "function(e, data) { return validateFileBeforeUploading(data,".$_REQUEST['uploadLimitValue'].");}",
            'fileuploaddone' => "function(e, data) {
            if(data.result.status===false){
            $('#error-load').html(data.result.message).show();
            } else{
                        $('#error-load').html('').hide();
            }
             if(data.result.files[0].status && !hasUploadErrors){ uploadRelatedFiles(data); afterUploadFromRecent(true); } else if(!data.result.files[0].status) {handelFileManagerUploadErrors(data); hasUploadErrors = true; return false;}}",
            'fileuploadfail' => "function(e, data) {}"
        ]]); ?>

    <script id="templateUpload" type="text/x-tmpl">
        {% for (var i=0, file; file=o.files[i]; i++) { %}
            <tr class="template-upload fade{%=o.options.loadImageFileTypes.test(file.type)?' image':''%}">
                <td style="width:10%">
                    <span class="preview"></span>
                </td>
                <td style="width:35%">
                    <p class="name">{%=file.name%}</p>
                    <strong class="error text-danger"></strong>
                </td>
                <td>
                    <p class="size"><span class="file-upload-processing" data-time="0"><?= Yii::t('fileupload', 'Processing...') ?></span></p>
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
            </td>
            <td>
                {% if (!i && !o.options.autoUpload) { %}
                    <button class="btn btn-primary start" disabled>
                        <i class="glyphicon glyphicon-upload"></i>
                        <span><?= Yii::t('app', 'Start') ?></span>
                    </button>
                {% } %}
                {% if (!i) { %}
                    <button class="btn btn-warning cancel">
                        <i class="glyphicon glyphicon-ban-circle"></i>
                        <span><?= Yii::t('app', 'Cancel') ?></span>
                    </button>
                {% } %}
            </td>
        </tr>
    {% } %}

    </script>
    <script id="templateDownload" type="text/x-tmpl">
        {% for (var i=0, file; file=o.files[i]; i++) { %}
            <tr class="template-download fade{%=file.thumbnailUrl?' image':''%}">
                <td>
                    <span class="preview">
                        {% if (file.thumbnailUrl) { %}
                            <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                        {% } %}
                    </span>
                </td>
                <td>
                    <p class="name">
                        {% if (file.url) { %}
                            <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                        {% } else { %}
                            <span>{%=file.name%}</span>
                        {% } %}
                    </p>
                    {% if (file.error) { %}
                        <div><span class="label label-danger">Error</span> {%=file.error%}</div>
                    {% } %}
                </td>
                <td>
                    <span class="size">{%=o.formatFileSize(file.size)%}</span>
                </td>
            </tr>
        {% } %}
    </script>
</div>

<div id="extraUploadTable" style="display:none">
    <table class="table advanced-video-upload-options" style="display:none">
        <tr style="display: none">
            <td colspan="3"><input type="button" name="file_id" value="0"></td>
        </tr>
        <tr class="file-video-thumbnail">
            <td style="width:125px"><?= Yii::t('app', 'Thumbnail') ?></td>
            <td>
                <input type="file" name="thumbnail">
                <div class="progress-bar progress-bar-success" style="width:0%;height: 10px;margin-top: 5px;"></div>
            </td>
            <td style="vertical-align: bottom">
                <button class="btn btn-sm btn-danger" title="clear">
                    <?= Yii::t('app', 'Clear') ?>
                </button>
            </td>
        </tr>
        <tr class="file-1080">
            <td>1080p</td>
            <td>
                <input type="file" name="resolution_1080">
                <div class="progress-bar progress-bar-success" style="width:0%;height: 10px;margin-top: 5px;"></div>
            </td>
            <td style="vertical-align: bottom">
                <button class="btn btn-sm btn-danger" title="clear">
                    <?= Yii::t('app', 'Clear') ?>
                </button>
            </td>
        </tr>
        <tr class="file-720">
            <td>720p</td>
            <td>
                <input type="file" name="resolution_720">
                <div class="progress-bar progress-bar-success" style="width:0%;height: 10px;margin-top: 5px;"></div>
            </td>
            <td style="vertical-align: bottom">
                <button class="btn btn-sm btn-danger" title="clear">
                    <?= Yii::t('app', 'Clear') ?>
                </button>
            </td>
        </tr>
        <tr class="file-480">
            <td>480p</td>
            <td>
                <input type="file" name="resolution_480">
                <div class="progress-bar progress-bar-success" style="width:0%;height: 10px;margin-top: 5px;"></div>
            </td>
            <td style="vertical-align: bottom">
                <button class="btn btn-sm btn-danger" title="clear">
                    <?= Yii::t('app', 'Clear') ?>
                </button>
            </td>
        </tr>
    </table>
</div>
<?php
if (Yii::$app->id == 'app-backend')
    $this->registerJs(<<<SCRIPT

$( document ).ready(function() {
    $('.modal-body').find('link:first').remove()
    $('.close').click(function(){ $('.file-manager-widget-modal').modal('hide') })
});


SCRIPT
    );

?>
<script>
    setInterval(function () {
        $('.file-upload-processing').each(function (item) {
            if ($(this).attr('data-time') == 3) {
                $(this).attr('class', 'text-danger');
                $(this).text('File not Accepted');
                $(this).closest('td').find('.progress').remove();
                $(this).closest('tr').find('td:last-child').html('');
            } else {
                $(this).attr('data-time', parseInt($(this).attr('data-time')) + 1);
            }
        });
    }, 3000);
</script>
<style>
    @keyframes blink {
        0%, 100% {
            color: black;
        }
        50% {
            color: cornflowerblue;
        }
    }

    .file-upload-processing {
        animation: blink 1s infinite;
        color: cornflowerblue;
    }
</style>
