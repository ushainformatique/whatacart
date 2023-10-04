<?php
use usni\library\utils\TimezoneUtil;

/* @var $formDTO \usni\library\modules\install\dto\InstallFormDTO */
/* @var $model \usni\library\modules\install\models\SettingsForm */
/* @var $form \usni\library\bootstrap\ActiveForm */
/* @var $this \usni\library\web\AdminView */

$model  = $formDTO->getModel();
?>
<?= $form->field($model, 'siteName')->textInput();?>
<?= $form->field($model, 'siteDescription')->textarea();?>
<?= $form->field($model, 'superUsername')->textInput();?>
<?= $form->field($model, 'superEmail')->textInput();?>
<?= $form->field($model, 'superPassword')->passwordInput();?>
<?= $form->field($model, 'environment')->select2Input($formDTO->getEnvironments(), false);?>
<?= $form->field($model, 'timezone')->select2Input(TimezoneUtil::getTimezoneSelectOptions());?>
<?= $form->field($model, 'logo')->fileInput();?>
<?= $form->field($model, 'demoData', ['horizontalCssClasses' => ['wrapper'   => 'col-sm-12'], 
                                      'horizontalCheckboxTemplate' => "{beginWrapper}\n<div class=\"checkbox\">\n{beginLabel}\n{input}\n{labelTitle}\n{endLabel}\n</div>\n{error}\n{endWrapper}"])->checkbox();?>
