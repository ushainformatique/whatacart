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
                                    'action' => $config['paypalUrl']
                               ]);
echo Html::hiddenInput('cmd', '_cart');
echo Html::hiddenInput('upload', "1");
echo Html::hiddenInput('business', $config['businessEmail']);


foreach($cart->itemsList as $item)
{
    $name = $item->name;
    if($item->displayedOptions != null)
    {
        $name .= '<br/>' . $item->displayedOptions; 
    }
    echo Html::hiddenInput('item_name_' . $index, $name);
    $priceByCurrency        = $this->getPriceByCurrency($item->price, UsniAdaptor::app()->currencyManager->selectedCurrency);
    echo Html::hiddenInput('amount_' . $index, $priceByCurrency);
    echo Html::hiddenInput('item_number_' . $index, $item->productId);
    echo Html::hiddenInput('quantity_' . $index, $item->qty);
    echo Html::hiddenInput('tax_' . $index, $this->getPriceByCurrency($item->tax, UsniAdaptor::app()->currencyManager->selectedCurrency));
    $index++;
}
if($order->shipping_fee > 0)
{
    //Shipping
    echo Html::hiddenInput('item_name_' . $index, UsniAdaptor::t('shipping', 'Shipping'));
    $shippingPriceByCurrency        = $order->shipping_fee;
    echo Html::hiddenInput('amount_' . $index, $shippingPriceByCurrency);
    echo Html::hiddenInput('item_number_' . $index, $index);
    echo Html::hiddenInput('quantity_' . $index, 1);
}
//Billing details
echo Html::hiddenInput('first_name', $checkout->billingInfoEditForm->firstname);
echo Html::hiddenInput('last_name', $checkout->billingInfoEditForm->lastname);
echo Html::hiddenInput('email', $checkout->billingInfoEditForm->email);
echo Html::hiddenInput('custom', $order->id);
echo Html::hiddenInput('address_override', "0");
echo Html::hiddenInput('paymentaction', $config['paymentAction']);
echo Html::hiddenInput('currency_code', UsniAdaptor::app()->currencyManager->selectedCurrency);
echo Html::hiddenInput('rm', '2');
echo Html::hiddenInput('return', $config['returnUrl'] . '?q=success');
echo Html::hiddenInput('cancel_return', $config['cancelUrl'] . '?q=cancel');
echo Html::hiddenInput('notify_url', $config['notifyUrl'] . '?q=ipn');
echo Html::hiddenInput('no_shipping', '1');
echo Html::hiddenInput('no_note', '1');
echo Html::hiddenInput('charset', 'utf-8');
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
