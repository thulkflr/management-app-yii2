<?php

use yii\helpers\Url;
use yii\helpers\Html;
use common\modules\thirdPartyIntegration\assets\GoogleMapsLatLngAssets;

/** @var $this \yii\web\View */
/** @var $model */
/** @var $attribute */

GoogleMapsLatLngAssets::register($this);
$uniqid = uniqid('google_maps_lat_lng');
?>
<div
        id="<?= $uniqid ?>"
        class="google-map-lat-lng-container"
>
    <div class="input-group">
        <?= Html::input('text', "lat_lng_{$uniqid}", $model->{$attribute}, ['class' => 'form-control', 'disabled' => true]) ?>
        <?= Html::activeHiddenInput($model, $attribute, ['value' => $model->{$attribute}, 'class' => 'form-control']); ?>
        <span class=" delete-selected-file text-danger input-group-addon remove-lat-lng"
              style="border-radius: 0 !important;">
            <i class="lnr-cross-circle fa fa-close fas fa-times"></i>
        </span>
        <span class="input-group-addon pick get-lat-lang"
              target-url="<?= Url::to(['/third-party-integration/google-maps/load-lat-lng', 'target' => $uniqid]) ?>">
            <i class="fa fa-globe"></i>
        </span>
    </div>
</div>