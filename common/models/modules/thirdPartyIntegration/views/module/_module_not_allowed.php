<?php
use yii\helpers\Url;
use common\helpers\DataPresentationHelper;
use common\modules\thirdPartyIntegration\handlers\base\Module;
?>
<div class="thr option-card">
    <div class="widget-content p-0">
        <div class="widget-content-wrapper">
            <div class="widget-content-left me-3">
                <img width="70" class="rounded-circle" src="<?= Url::to(["/modules_images/{$modelThirdPartyIntegrationModule->icon}"]) ?>" alt="">
            </div>
            <div class="widget-content-left">
                <div class="widget-heading"><?= Yii::t('app', $modelThirdPartyIntegrationModule->name) ?>
                    <?php if($isIntegrated){ ?>
                        <?=DataPresentationHelper::getColoredText('success',Yii::t('app','Connected'))?>
                    <?php } ?>
                </div>
                <div class="widget-subheading">
                    <?= Module::moduleShortBrief($modelThirdPartyIntegrationModule->module_id) ?>


                </div>
            </div>

        </div>
    </div>
</div>
<div class="thr option-card">
    <div class="widget-content p-0">
        <div class="widget-content-wrapper">
            <h5 class="mt-2 text-center text-muted w-100"><i class="fa-solid fa-triangle-exclamation"></i> <?=Yii::t('app','Module Not Available For Your Plan')?></h5>
        </div>
    </div>
</div>
