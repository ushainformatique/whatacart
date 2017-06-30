<?php

/* @var $formDTO \common\modules\payment\dto\PaypalStandardFormDTO */
/* @var $form \usni\library\bootstrap\TabbedActiveForm */

$model                  = $formDTO->getPaypalSettings();
$transactionTypeArray   = $formDTO->getTransactionType();
if($model->return_url == null)
{
    $model->return_url = '/payment/paypal_standard/site/return';
}
if($model->cancel_url == null)
{
    $model->cancel_url = '/payment/paypal_standard/site/cancel';
}
if($model->notify_url == null)
{
    $model->notify_url = '/payment/paypal_standard/site/notify';
}
?>

<?= $form->field($model, 'business_email')->textInput();?>
<?= $form->field($model, 'return_url')->textInput();?>
<?= $form->field($model, 'cancel_url')->textInput();?>
<?= $form->field($model, 'notify_url')->textInput();?>
<?= $form->field($model, 'transactionType')->select2input($transactionTypeArray);?>
<?= $form->field($model, 'sandbox', ['horizontalCssClasses' => ['wrapper'   => 'col-sm-12'], 
                                         'horizontalCheckboxTemplate' => "{beginWrapper}\n<div class=\"checkbox\">\n{beginLabel}\n{input}\n{labelTitle}\n{endLabel}\n</div>\n{error}\n{endWrapper}"])->checkbox();?>