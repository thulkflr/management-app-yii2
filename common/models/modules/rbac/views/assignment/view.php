<?php

use yii\helpers\Html;
use yii\helpers\Json;
use common\modules\rbac\RbacAsset;
use yii\helpers\Url;

RbacAsset::register($this);

/* @var $this yii\web\View */
/* @var $model \common\modules\rbac\models\AssignmentModel */
/* @var $usernameField string */


$this->context->pageTitleIcon = 'pe-7s-unlock';
$this->context->backText= Yii::t('app', 'Back To Users List');
$this->context->backlink=Url::to(['index']);


$userName = $model->user->email;
$this->title = Yii::t('app', 'Manage {0} Access', $userName);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->render('/layouts/_sidebar');
?>

<div class="thr option-card">

                <?php echo $this->render('../_dualListBox', [
                    'opts' => Json::htmlEncode([
                        'items' => $model->getItems(),
                    ]),
                    'assignUrl' => ['assign', 'id' => $model->userId],
                    'removeUrl' => ['remove', 'id' => $model->userId],
                ]); ?>
</div>
