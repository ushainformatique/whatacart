<?php
use usni\library\components\UiHtml;
use usni\UsniAdaptor;

$continueShoppingLabel      = UsniAdaptor::t('cart', 'Continue Shopping');
$homeUrl                    = UsniAdaptor::app()->getHomeUrl();

$checkoutLabel  = UsniAdaptor::t('cart', 'Checkout');
$checkoutLink   = UiHtml::a($checkoutLabel, UsniAdaptor::createUrl('cart/checkout/index'), ['class' => 'btn btn-success']);
if(!empty($products))
{
    $continueShoppingLink   = UiHtml::a($continueShoppingLabel, $homeUrl, ['class' => 'btn btn-default']);
?>
    <div class="buttons">
        <div class="pull-left">
            <?php echo $continueShoppingLink;?>
        </div>
        <div class="pull-right">
            <?php echo $checkoutLink;?>
        </div>
    </div>
<?php
}
else
{
    $continueShoppingLink   = UiHtml::a($continueShoppingLabel, $homeUrl, ['class' => 'btn btn-success']);
?>
    <div class="buttons">
        <div class="pull-right">
            <?php echo $continueShoppingLink;?>
        </div>
    </div>
<?php
}
?>
