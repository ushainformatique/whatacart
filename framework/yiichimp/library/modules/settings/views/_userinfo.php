<?php
use usni\library\modules\notification\utils\NotificationUtil;

/* @var $form \usni\library\bootstrap\TabbedActiveForm */

$model   = $formDTO->getModel();
?>

<?= $form->field($model, 'fromName')->textInput();?>
<?= $form->field($model, 'fromAddress')->textInput();?>
<?= $form->field($model, 'replyToAddress')->textInput();?>
<?= $form->field($model, 'sendingMethod')->dropDownList(NotificationUtil::getMailSendingMethod());?>
<?= $form->field($model, 'sendTestMail')->checkbox();?>
<?= $form->field($model, 'testEmailAddress')->textInput();?>
<?= $form->field($model, 'testMode', ['horizontalCheckboxTemplate' => "<div class=\"checkbox checkbox-admin\">\n{beginLabel}\n{input}\n{labelTitle}\n{endLabel}\n</div>\n{error}"])->checkbox();?>