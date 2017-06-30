<?php
use usni\library\utils\Html;
use usni\UsniAdaptor;

/* @var $this \frontend\web\View */
/* @var $form \usni\library\bootstrap\ActiveForm */
/* @var $formDTO \cart\dto\CheckoutDTO */
$paymentMethods = $formDTO->getPaymentMethods();
$model          = $formDTO->getCheckout()->paymentMethodEditForm;
if($model->payment_method == null)
{
    $keys = array_keys($paymentMethods);
    $model->payment_method = $keys[0];
}
echo $form->field($model, 'payment_method')->radioList($paymentMethods)->label(false);
if($formDTO->getInterface() == 'front')
{
    echo $form->field($model, 'agree', ['horizontalCssClasses' => ['wrapper'   => 'col-sm-12'], 
                                      'checkboxTemplate' => "{beginWrapper}\n<div class=\"checkbox\">\n{beginLabel}\n{input}\n{labelTitle}\n" . ' <a href="#termsModal" data-toggle="modal">' .  UsniAdaptor::t('application', 'Terms and Conditions') . '</a>' . "{endLabel}\n</div>\n{error}\n{endWrapper}"])->checkbox();
    echo $this->render('/_termsmodal', ['formDTO' => $formDTO]);
}
else
{
    echo Html::activeHiddenInput($model, 'agree', ['value' => 1]);
}