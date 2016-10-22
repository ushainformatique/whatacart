<?php
use usni\UsniAdaptor;
use wishlist\utils\WishlistUtil;
use products\utils\CompareProductsUtil;
use common\modules\stores\utils\StoreUtil;

$accountLabel = UsniAdaptor::t('users', 'My Account');
$username     = null;
if (!UsniAdaptor::app()->user->isGuest)
{
    $username   = UsniAdaptor::app()->user->getUserModel()->username;
    $accountUrl = UsniAdaptor::createUrl('customer/site/my-account');
}
else
{
    $accountUrl = UsniAdaptor::createUrl('customer/site/login');
}
?>
<div id="top-links" class="nav pull-right">
    <ul class="list-inline">
        <li class="dropdown">
            <a href="<?php echo $accountUrl; ?>" title="<?php echo $accountLabel; ?>" class="dropdown-toggle" data-toggle="dropdown">
                <?php
                if($username == null)
                {
                ?>
                    <span class="hidden-xs hidden-sm hidden-md"><?php echo $accountLabel; ?></span> 
                <?php
                }
                else
                {
                ?>
                    <span class="hidden-xs hidden-sm hidden-md"><?php echo $username; ?></span>
                <?php
                }
                ?> 
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-right">
                <?php if(!UsniAdaptor::app()->user->isGuest)
                {
                    ?>
                    <li>
                        <a href="<?php echo $accountUrl; ?>">
                            <?php echo $accountLabel; ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo UsniAdaptor::createUrl('customer/site/logout'); ?>">
                            <?php echo UsniAdaptor::t('users', 'Logout'); ?>
                        </a>
                    </li>
                <?php
                }
                else
                {
                    $loginUrl = UsniAdaptor::createUrl('customer/site/login');
                    $registerUrl = UsniAdaptor::createUrl('customer/site/register');
                    ?>
                    <li>
                        <a href="<?php echo $registerUrl; ?>">
                            <?php echo UsniAdaptor::t('users', 'Register'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $loginUrl; ?>">
                            <?php echo UsniAdaptor::t('users', 'Login'); ?>
                        </a>
                    </li>
<?php } ?>
            </ul>
        </li>
        
        <?php
        $wishlistSetting = StoreUtil::getSettingValue('allow_wishlist');
        if($wishlistSetting)
        {
        ?>
        <li>
            <a href="<?php echo UsniAdaptor::createUrl('wishlist/default/view'); ?>" id="wishlist-total" title="<?php echo UsniAdaptor::t('wishlist', 'Wish List'); ?>" class="top-nav-wishlist">
                <span class="hidden-xs hidden-sm hidden-md"><?php echo WishlistUtil::renderWishlistInTopnav(); ?></span>
            </a>
        </li>
        <?php
        }
        ?>
        
        <li>
            <?php 
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
        $compareProductsSetting = StoreUtil::getSettingValue('allow_compare_products');
        if($compareProductsSetting)
        {
        ?>
        <li>
            <?php 
            $compareLabel = UsniAdaptor::t('products', 'Compare');
            $compareUrl   = UsniAdaptor::createUrl('/catalog/products/site/compare-products');
            $label        = CompareProductsUtil::renderCompareProductsInTopnav();
            ?>
            <a href="<?php echo $compareUrl; ?>" title="<?php echo $compareLabel;?>">
                <span class="hidden-xs hidden-sm hidden-md top-nav-compareproduct"><?php echo $label; ?></span>
            </a>
        </li>
        <?php
        }
        ?>
    </ul>
</div>