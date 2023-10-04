<?php
use marqu3s\summernote\Summernote;

$model  = $formDTO->getModel();
?>

<?= $form->field($model, 'siteName')->textInput(); ?>
<?= $form->field($model, 'siteDescription')->textarea(); ?>
<hr/>
<?= $form->field($model, 'metaKeywords')->textarea(); ?>
<?= $form->field($model, 'metaDescription')->textarea(); ?>
<?= $form->field($model, 'siteMaintenance', ['horizontalCssClasses' => ['wrapper'   => 'col-sm-12'], 
                                         'horizontalCheckboxTemplate' => "{beginWrapper}\n<div class=\"checkbox\">\n{beginLabel}\n{input}\n{labelTitle}\n{endLabel}\n</div>\n{error}\n{endWrapper}"])->checkbox();?>
<?= $form->field($model, 'customMaintenanceModeMessage')->widget(Summernote::className()); ?>