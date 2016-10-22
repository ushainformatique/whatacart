<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
use usni\fontawesome\FA;
use products\utils\ProductUtil;
use common\utils\ApplicationUtil;
use common\modules\stores\utils\StoreUtil;

extract($data);

$wishlistImageWidth      = StoreUtil::getImageSetting('wishlist_image_width', 55);
$wishlistImageHeight     = StoreUtil::getImageSetting('wishlist_image_height', 55);
$thumbnail = ApplicationUtil::getImage($thumbnail, 'wishlist', $wishlistImageWidth, $wishlistImageHeight);
?>
<tr>
    <td class="text-center">                  
        <a href="<?php echo $url;?>"><?php echo $thumbnail;?></a>
    </td>
    <td class="text-left">
        <a href="<?php echo $url;?>">
            <?php
                echo ProductUtil::renderOutOfStockMessage($name, $stock_status);
            ?>
        </a>
    </td>
    <td class="text-left"><?php echo $model;?></td>
    <td class="text-right"><?php echo ProductUtil::getFormattedPrice($unit_price);?></td>
    <td class="text-right">
        <input type="hidden" name="quantity" size="2" value="1" />
        <button type="button" title="" class="btn btn-success btn-sm add-cart" data-productid = "<?php echo $product_id;?>" id="addtocart-<?php echo $product_id;?>">
            <?php echo FA::icon('shopping-cart');?>
        </button>
        <button type="button" title="" class="btn btn-danger btn-sm wishlist-remove" data-productid = "<?php echo $product_id;?>" id="removefromcart-<?php echo $product_id;?>">
            <?php echo FA::icon('times');?>
        </button>
    </td>
</tr>