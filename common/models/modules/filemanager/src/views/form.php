<?php
/** @var \common\modules\filemanager\src\FileUploadUI $this */
use yii\helpers\Html;
/* @var $this yii\web\View */

$context = $this->context;
?>
    <!-- The file upload form used as target for the file upload widget -->
<?= Html::beginTag('div', $context->options); ?>
    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
    <div class="row fileupload-buttonbar">
        <div class="col-lg-12">
            <!-- The fileinput-button span is used to style the file input field as button -->
            <label for="<?=$context->fieldOptions['id']?>" class="btn btn-success fileinput-button">
                <i class="pe-7s-plus glyphicon glyphicon-plus"></i>
                <span><?= Yii::t('app', 'Add files') ?>...</span>



            </label>
            <?= $context->model instanceof \yii\base\Model && $context->attribute !== null
                ? Html::activeFileInput($context->model, $context->attribute, $context->fieldOptions)
                : Html::fileInput($context->name, $context->value, $context->fieldOptions);?>
            <a class="btn btn-primary start">
                <i class="pe-7s-upload glyphicon glyphicon-upload"></i>
                <span><?= Yii::t('app', 'Start upload') ?></span>
            </a>
            <a class="btn btn-warning cancel">
                <i class="pe-7s-close-circle glyphicon glyphicon-ban-circle"></i>
                <span><?= Yii::t('app', 'Cancel upload') ?></span>
            </a>
            <a class="btn btn-danger delete">
                <i class="lnr-trash glyphicon glyphicon-trash"></i>
                <span><?= Yii::t('app', 'Delete') ?></span>
            </a>
            <input type="checkbox" class="toggle">
            <!-- The global file processing state -->
            <span class="fileupload-process"></span>
        </div>
        <!-- The global progress state -->
        <div class="col-lg-12 fileupload-progress fade">
            <!-- The global progress bar -->
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar progress-bar-success" style="width:0%;padding: 8px 0;"></div>
            </div>
            <!-- The extended global progress state -->
            <div class="progress-extended">&nbsp;</div>
        </div>
    </div>
    <!-- The table listing the files available for upload/download -->
    <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
<?= Html::endTag('div');?>
<?php $this->registerJs("
    $(document).ready(function() {
        $('.file-uploader-tabs').click(function(){
           var tabId=$(this).attr('data-href');
           console.log('giiiiiiiiiiiiiii',tabId);
           $('.file-manager-tab-pane').removeClass('active');
           $(tabId).addClass('active');
           $('.file-manager-nav-link').removeClass('active');
           $(this).addClass('active');
        })
    });
");
?>