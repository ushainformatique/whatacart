<?php
use usni\library\utils\Html;
use common\utils\ApplicationUtil;
use usni\UsniAdaptor;
use products\behaviors\PriceBehavior;
use frontend\widgets\ActiveForm;

/* @var $this \frontend\web\View */
$this->attachBehavior('priceBehavior', PriceBehavior::className());

$cart       = ApplicationUtil::getCart();
$checkout   = ApplicationUtil::getCheckout();

$order                  = $checkout->order;
$index                  = 1;
$form = ActiveForm::begin([
                                    'id'     => 'paypalconfirmview', 
                                    'layout' => 'horizontal',
                                    'caption'=> '',
                                    'decoratorView' => false,
                                    'action' => UsniAdaptor::createUrl('/payment/paypal_standard/confirm/validate')
                               ]);
if($config['businessEmail'] == null)
{
    echo Html::tag('div', 'Business email is missing for the payment gateway. You could not proceed with the order processing.', ['class' => 'alert alert-danger']);
}
elseif($config['paypalSandbox'] == true)
{
    echo Html::tag('div', 'The payment gateway is currently in sandbox mode. You would not be charged for the transaction.', ['class' => 'alert alert-warning']);
    echo $this->render('@cart/views/_confirmorderbuttons');
}
else
{
    echo $this->render('@cart/views/_confirmorderbuttons');
}
ActiveForm::end();
