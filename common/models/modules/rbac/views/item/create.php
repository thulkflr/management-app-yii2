<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model \common\modules\rbac\models\AuthItemModel */

$labels = $this->context->getLabels();
$this->title = Yii::t('app', 'Create ' . $labels['Item']);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Organizations Setup'), 'url' => ['/site/menu-page','type'=>'organizations_setup']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', $labels['Items']), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->render('/layouts/_sidebar');
?>
<?php echo $this->render('_form', [
    'model' => $model,
]); ?>