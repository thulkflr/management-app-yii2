<?php

use backend\helpers\AdminThemeHelper;
use common\helpers\DataPresentationHelper;
use common\modules\thirdPartyIntegration\handlers\base\Field;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\modules\thirdPartyIntegration\handlers\base\Module;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form backend\widgets\ActiveForm */
/* @var $model */
/* @var $fields */

$config = Module::getModel($modelThirdPartyIntegrationModule->module_id, Yii::$app->organization->id);
$isIntegrated = Module::checkIfIntegrated($config);

if (Yii::$app->organization->orgBasicSetting->isGrowthPlan()) {
    if (in_array($config->module_id, [Module::MODULE_ID_MOYASAR, Module::MODULE_ID_HYPER_PAY, Module::MODULE_ID_MY_FATOORAH])) {
        echo $this->render('_module_not_allowed', ['modelThirdPartyIntegrationModule' => $modelThirdPartyIntegrationModule, 'isIntegrated' => $isIntegrated]);
        return;
    }
}


$form = ActiveForm::begin([
        'id' => 'frm3rdPartyModule',
        'enableClientValidation' => true,
        'options' => [
                'validateOnSubmit' => true,
                'class' => 'form'
        ],
]);
?>

<div class="thr option-card">
    <div class="widget-content p-0">
        <div class="widget-content-wrapper">
            <div class="widget-content-left me-3">
                <img width="70" class="rounded-circle"
                     src="<?= Url::to(["/modules_images/{$modelThirdPartyIntegrationModule->icon}"]) ?>" alt="">
            </div>
            <div class="widget-content-left">
                <div class="widget-heading"><?= Yii::t('app', $modelThirdPartyIntegrationModule->name) ?>
                    <?php if ($isIntegrated) { ?>
                        <?= DataPresentationHelper::getColoredText('success', Yii::t('app', 'Connected')) ?>
                    <?php } ?>
                </div>
                <div class="widget-subheading">
                    <?= Module::moduleShortBrief($modelThirdPartyIntegrationModule->module_id) ?>


                </div>
            </div>

        </div>
    </div>
</div>


<?php if ($modelThirdPartyIntegrationModule->module_id == Module::MODULE_ID_ZOOM): ?>
    <!-- Zoom Scopes Information -->
    <div class="thr option-card" style="margin-top: 20px;">
        <div class="col-md-12">
            <div class="alert alert-info" role="alert">
                <h5><strong><?= Yii::t('app', 'How to add Scopes to Zoom Account') ?></strong></h5>
            </div>
            <div style="margin-top: 15px;">
                <ol>
                    <li>Open your Zoom account.</li>
                    <li>From the main menu, click on Solutions and select App Marketplace</li>
                    <li>Click on Develop and select Build App</li>
                    <li>Choose Server-to-Server OAuth and then click Create</li>
                    <li>Enter the name you want and click Create</li>
                    <li>Click on Scopes, add the scope listed below, and click Save</li>
                    <li>Enter the App Credentials in our platform</li>
                </ol>
            </div>
        </div>
    </div>
<?php endif; ?>




<?php if (!$isIntegrated && is_string(Module::moduleIntegrateSteps($model->module_id))) { ?>
    <div class="thr option-card">
        <div class="full-steps-instructions-<?= $model->module_id ?>">
            <?= $this->render('@' . Module::moduleIntegrateSteps($model->module_id)) ?>
        </div>
    </div>
<?php } ?>
<div class="thr option-card">

    <?php foreach ($fields as $field): ?>
        <div class="row">
            <div class="col-md-12">
                <?php if ($field->field_type == Field::TYPE_CHECKBOX) { ?>
                    <div class="col-md-12 pr-4">

                        <?= $form->field($model, $field->field_name)->checkbox(AdminThemeHelper::getCheckboxAttrs())->label($field->field_label) ?>
                    </div>
                <?php } else { ?>
                    <?= $form->field($model, $field->field_name)->input($field->field_type)->label($field->field_label) ?>
                <?php } ?>
            </div>
        </div>
    <?php endforeach; ?>
    <?php
    if (file_exists(Yii::getAlias("@common/modules/thirdPartyIntegration/views/module/scripts/$id.php")))
        echo $this->render("scripts/$id")
    ?>
    <div class="form-group3">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success pull-right mb-3']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <?php $this->registerJs("
   $(\"[data-toggle='toggle']\").bootstrapToggle('destroy')
        $(\"[data-toggle='toggle']\").bootstrapToggle();
");
    $this->registerCss("
  .toggle.btn{
      margin-left:0px !important
  }
  .checkbox label{
      font-weight: bold;
  }
");
    ?>
</div>

<?php if ($modelThirdPartyIntegrationModule->module_id == Module::MODULE_ID_ZOOM): ?>
    <!-- Zoom Scopes Information -->
    <div class="thr option-card" style="margin-top: 20px;">
        <div class="col-md-12">
            <div class="alert alert-info" role="alert">
                <h5><strong><?= Yii::t('app', 'Important: Zoom API Scopes Required') ?></strong></h5>
                <p><?= Yii::t('app', 'Please make sure all the following scopes are added to your Zoom portal application settings.') ?></p>
            </div>
            <div style="margin-top: 15px;">
                <h6><strong><?= Yii::t('app', 'Required Scopes') ?></strong></h6>
                <ul style="list-style: none; padding-left: 0;">
                    <li><code>meeting:read:list_summaries:admin</code></li>
                    <li><code>meeting:read:past_meeting_instances:admin</code></li>
                    <li><code>meeting:read:list_past_instances</code></li>
                    <li><code>meeting:read:list_past_instances:admin</code></li>
                    <li><code>meeting:read:list:admin</code></li>
                    <li><code>meeting:write:create:admin</code> (if creating)</li>
                    <li><code>user:read:list:admin</code></li>
                    <li><code>meeting:read:registrants:admin</code></li>
                    <li><code>meeting:write:registrants:admin</code></li>
                    <li><code>webinar:read:list:admin</code></li>
                    <li><code>webinar:write:update:admin</code></li>
                    <li><code>webinar:write:delete:admin</code></li>
                    <li><code>webinar:read:registrants:admin</code></li>
                    <li><code>webinar:write:registrants:admin</code></li>
                    <li><code>webinar:read:panelists:admin</code></li>
                    <li><code>webinar:write:panelists:admin</code></li>
                    <li><code>webinar:read:polls:admin</code></li>
                    <li><code>webinar:write:polls:admin</code></li>
                    <li><code>report:read:webinar_participants:admin</code></li>
                    <li><code>report:read:meeting_participants:admin</code></li>
                    <li><code>meeting:read:details:admin</code></li>
                </ul>
            </div>
        </div>
    </div>
<?php endif; ?>

