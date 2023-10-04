<?php

/* @var $form \usni\library\bootstrap\TabbedActiveForm */

$model   = $formDTO->getModel();
?>
<?= $form->field($model, 'smtpHost')->textInput();?>
<?= $form->field($model, 'smtpPort')->textInput();?>
<?= $form->field($model, 'smtpUsername')->textInput();?>
<?= $form->field($model, 'smtpPassword')->passwordInput();?>