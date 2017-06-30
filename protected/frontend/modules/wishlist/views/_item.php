<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
use usni\fontawesome\FA;
use frontend\widgets\OutOfStockBadge;
use products\behaviors\PriceBehavior;
use usni\UsniAdaptor;

/* @var $this \frontend\web\View */

$this->attachBehavior('priceBehavior', PriceBehavior::className());

$thumbnail      = $this->renderImageByStoreSettings($item, 'thumbnail', 'wishlist', 55, 55);
$url            = UsniAdaptor::createUrl('catalog/products/site/detail', ['id' => $item->productId]);
?>
<tr>
    <td class="text-center">                  
        <a href="<?php echo $url;?>"><?php echo $thumbnail;?></a>
    </td>
    <td class="text-left">
        <a href="<?php echo $url;?>">
            <?php
                echo OutOfStockBadge::widget(['name' => $item->name, 'stockStatus' => $item->stockStatus]);
            ?>
        </a>
    </td>
    <td class="text-left"><?php echo $item->model;?></td>
    <td class="text-right"><?php echo $this->getFormattedPrice($item->price, UsniAdaptor::app()->currencyManager->selectedCurrency);?></td>
    <td class="text-right">
        <input type="hidden" name="quantity" size="2" value="1" />
        <button type="button" title="" class="btn btn-success btn-sm add-cart" data-productid = "<?php echo $item->productId;?>" id="addtocart-<?php echo $item->productId;?>">
            <?php echo FA::icon('shopping-cart');?>
        </button>
        <button type="button" title="" class="btn btn-danger btn-sm wishlist-remove" data-productid = "<?php echo $item->productId;?>" id="removefromcart-<?php echo $item->productId;?>">
            <?php echo FA::icon('times');?>
        </button>
    </td>
</tr>