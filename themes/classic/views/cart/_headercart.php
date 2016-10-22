<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
use usni\UsniAdaptor;
use products\utils\ProductUtil;
use usni\fontawesome\FA;

$currencyCode = UsniAdaptor::app()->currencyManager->getDisplayCurrency();
?>

<div class="dropdown pull-right"> 
    <a class="dropdown-toggle" data-toggle="dropdown">
        <?php echo FA::icon("shopping-cart");?> 
        <span id="cart-total"><?php echo $itemCount; ?> <?php echo UsniAdaptor::t('cart', 'Item'); ?>(s) - <?php echo $itemCost; ?></span>
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu pull-right">
    <?php
    if ($itemCount == 0)
    {
        ?>
        <li>
            <p class="text-center"><?php echo UsniAdaptor::t('cart', 'Your shopping cart is empty!'); ?></p>
        </li>
        <?php
    }
    else
    {
        ?>
        <li>
            <div class="header-cart-title"><?php echo UsniAdaptor::t('cart', 'View Cart');?></div>
        </li>
        <li>
            <table class="table">
                <tbody>
                    <?php echo $items; ?>
                </tbody>
            </table>
        </li>
        <li>
            <div>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td class="text-right"><strong><?php echo UsniAdaptor::t('products', 'Sub-Total'); ?></strong></td>
                            <td class="text-right"><?php echo ProductUtil::getPriceWithSymbol($totalUnitPrice, $currencyCode);?></td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong><?php echo UsniAdaptor::t('tax', 'Tax'); ?></strong></td>
                            <td class="text-right"><?php echo ProductUtil::getPriceWithSymbol($totalTax, $currencyCode); ?></td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong><?php echo UsniAdaptor::t('products', 'Total'); ?></strong></td>
                            <td class="text-right"><?php echo ProductUtil::getPriceWithSymbol($totalPrice, $currencyCode); ?></td>
                        </tr>
                    </tbody>
                </table>
                <p class="text-right">
                    <a href="<?php echo UsniAdaptor::createUrl('cart/default/view');?>"><?php echo UsniAdaptor::t('cart', 'View Cart');?></a> | 
                    <a href="<?php echo UsniAdaptor::createUrl('cart/checkout/index');?>"><?php echo UsniAdaptor::t('cart', 'Checkout');?></a>
                </p>
            </div>
        </li>
        <?php
    }
    ?>
    </ul>
</div>