<?php
use usni\UsniAdaptor;
use frontend\widgets\MyAccount;
use wishlist\widgets\TopNavWishlist;
use products\widgets\TopNavCompareProducts;

$allowWishList      = UsniAdaptor::app()->storeManager->getSettingValue('allow_wishlist');
$allowCompare       = UsniAdaptor::app()->storeManager->getSettingValue('allow_compare_products');
?>
<div id="top-links" class="nav pull-right">
    <ul class="list-inline">
        <?php echo MyAccount::widget();?>
        <?php
        if($allowWishList)
        {
        ?>
        <li>
            <a href="<?php echo UsniAdaptor::createUrl('wishlist/default/view'); ?>" id="wishlist-total" title="<?php echo UsniAdaptor::t('wishlist', 'Wish List'); ?>" class="top-nav-wishlist">
                <span class="hidden-xs hidden-sm hidden-md"><?php echo TopNavWishlist::widget(); ?></span>
            </a>
        </li>
        <?php
        }
        ?>
        
        <li>
            <?php
            //TODO @Mayank need to fix
            $shoppingCartLabel = UsniAdaptor::t('cart', 'Shopping Cart');
            ?>
            <a href="<?php echo UsniAdaptor::createUrl('/cart/default/view'); ?>" title="<?php echo $shoppingCartLabel; ?>"> 
                <span class="hidden-xs hidden-sm hidden-md"><?php echo $shoppingCartLabel; ?></span>
            </a>
        </li>
        <li>
            <?php
            $checkoutLabel = UsniAdaptor::t('cart', 'Checkout');
            $checkOutUrl   = UsniAdaptor::createUrl('cart/checkout/index');
            ?>
            <a href="<?php echo $checkOutUrl; ?>" title="<?php echo $checkoutLabel; ?>">
                <span class="hidden-xs hidden-sm hidden-md"><?php echo $checkoutLabel; ?></span>
            </a>
        </li>
        
        <?php
        if($allowCompare)
        {
        ?>
        <li>
            <?php
            $compareLabel = UsniAdaptor::t('products', 'Compare');
            $compareUrl   = UsniAdaptor::createUrl('/catalog/products/site/compare-products');
            ?>
            <a href="<?php echo $compareUrl; ?>" title="<?php echo $compareLabel;?>">
                <span class="hidden-xs hidden-sm hidden-md top-nav-compareproduct"><?php echo TopNavCompareProducts::widget(); ?></span>
            </a>
        </li>
        <?php
        }
        ?>
    </ul>
</div>