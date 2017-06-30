<?php
/* @var $this \frontend\web\View */
/* @var $form \usni\library\bootstrap\ActiveForm */
/* @var $formDTO \cart\dto\CheckoutDTO */
$shippingMethods = $formDTO->getShippingMethods();
$model          = $formDTO->getCheckout()->deliveryOptionsEditForm;
if($model->shipping == null)
{
    $keys = array_keys($shippingMethods);
    $model->shipping = $keys[0];
}
echo $form->field($model, 'shipping')->radioList($shippingMethods)->label(false);