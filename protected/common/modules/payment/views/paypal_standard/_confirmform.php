<?php
use usni\library\utils\Html;
use common\utils\ApplicationUtil;
use usni\UsniAdaptor;
use products\behaviors\PriceBehavior;

/* @var $this \frontend\web\View */

$this->attachBehavior('priceBehavior', PriceBehavior::className());

$cart       = ApplicationUtil::getCart();
$checkout   = ApplicationUtil::getCheckout();

$order                  = $checkout->order;
$index                  = 1;

echo "<html>\n";
echo "<head><title>Processing Payment...</title></head>\n";
echo "<body onLoad=\"document.form.submit();\">\n";
echo "<center><h3>Please wait, your order is being processed...</h3></center>\n";
echo "<form method=\"post\" name=\"form\" action=\"" . $config['paypalUrl'] . "\">\n";
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
echo "</form>\n";
echo "</body></html>\n";
