<?php
/**@var $this \yii\web\View* */

use common\modules\filemanager\src\FileUploadUI;
use common\modules\filemanager\assets\UploaderUIAssets;

UploaderUIAssets::register($this);

/** @var $folder_id */

//$formViewPath = '/default/forms/file_upload_form';

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

<img id="previewImage">

<?= FileUploadUI::widget([
    'uploadTemplateId' => 'templateUpload',
    'downloadTemplateId' => 'templateDownload',
    //'formView' => $formViewPath,
    'model' => new \common\modules\filemanager\models\File(),
    'attribute' => 'file_object',
    'url' => ['default/upload', 'folder_id' => $folder_id],
    'gallery' => false,
    'fieldOptions' => [
        'multiple' => false,
    ],
    'clientEvents' => [
        'fileuploadadd' => "function(e, data) { return validateFileBeforeUploading(data);}",
        'fileuploaddone' => "function(e, data) {if(data.result.files[0].status){ uploadRelatedFiles(data); reloadManager({'folder_id': $('#selectedFolderID').val()}); reloadLeftSideContent(); } else {return handelFileManagerUploadErrors(data);}}",
        'fileuploadfail' => "function(e, data) {console.log(data); /*hideModal(); alertMessage('Files not uploaded.',0);*/ }",
    ],
]); ?>

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
                <p class="size"><span class="file-upload-processing" data-time="0"><?= Yii::t('app', 'Processing...') ?></span></p>
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
            <td style="width:10%">
                <span class="preview">
                    {% if (file.thumbnailUrl) { %}
                        <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                    {% } %}
                </span>
            </td>
            <td style="width:50%">
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