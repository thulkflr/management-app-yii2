<?php

use common\modules\filemanager\assets\BackendManagerAssets;
use common\modules\filemanager\assets\FrontendManagerAssets;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\virtualExperience\models\VirtualExperienceExhibitor */
/* @var $listDataProvider yii\data\ActiveDataProvider */
/* @var $sFolder \common\modules\filemanager\models\Folder */

/* @var $orgUsedSize */
/* @var $orgStorageSize */
/* @var $searchKeyword */

$this->context->pageTitleIcon = 'pe-7s-folder';
$this->context->backText= Yii::t('app', 'Back To Dashboard');
$this->context->backlink=Url::to(['/']);

if (Yii::$app->id == 'app-backend') {
    BackendManagerAssets::register($this);
} else {
    FrontendManagerAssets::register($this);
}
if(Yii::$app->id == 'app-frontend')
    $this->registerCssFile(Yii::getAlias('@web/css/custom/custom.css'), ['depends' => (\frontend\assets\HomePageAsset::className()), 'position' => \yii\web\View::POS_HEAD]);
else
    $this->registerCssFile(Yii::getAlias('@web/css/custom/custom.css'), [ 'position' => \yii\web\View::POS_HEAD]);

$this->title = Yii::t('app', 'File Manager');
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Data Management'), 'url' => ['/site/menu-page','type'=>'data_setup']];

?>

    <div class="row">
        <div class="left col-md-3">
            <?= $this->render('../layouts/partial/manager/_left.php', [
                'orgStorageSize' => $orgStorageSize,
                'orgUsedSize' => $orgUsedSize,
            ]) ?>
        </div>
        <div class="center col-md-9">
            <?= $this->render('../layouts/partial/manager/_center', [
                'listDataProvider' => $listDataProvider,
                'sFolder' => $sFolder,
                'searchKeyword' => $searchKeyword
            ]) ?>
        </div>
    </div>
