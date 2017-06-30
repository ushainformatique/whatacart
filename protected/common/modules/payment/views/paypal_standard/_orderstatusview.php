<?php

/* @var $formDTO \common\modules\payment\dto\PaypalStandardFormDTO */
/* @var $form \usni\library\bootstrap\TabbedActiveForm */

$model  = $formDTO->getPaypalOrderStatus();
$data   = $formDTO->getOrderStatusDropdownData();

?>
<?= $form->field($model, 'canceled_reversal_status')->select2input($data);?>
<?= $form->field($model, 'completed_status')->select2input($data);?>
<?= $form->field($model, 'denied_status')->select2input($data);?>
<?= $form->field($model, 'expired_status')->select2input($data);?>
<?= $form->field($model, 'failed_status')->select2input($data);?>
<?= $form->field($model, 'pending_status')->select2input($data);?>
<?= $form->field($model, 'processed_status')->select2input($data);?>
<?= $form->field($model, 'refunded_status')->select2input($data);?>
<?= $form->field($model, 'reversed_status')->select2input($data);?>
<?= $form->field($model, 'voided_status')->select2input($data);?>