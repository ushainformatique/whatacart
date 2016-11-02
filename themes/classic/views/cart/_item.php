<?php
use usni\fontawesome\FA;
use usni\UsniAdaptor;
use products\utils\ProductUtil;
use common\utils\ApplicationUtil;
use common\modules\stores\utils\StoreUtil;

extract($data);
$cartImageWidth     = StoreUtil::getImageSetting('cart_image_width', 55);
$cartImageHeight    = StoreUtil::getImageSetting('cart_image_height', 55);
$thumbnail = ApplicationUtil::getImage($thumbnail, 'cart', $cartImageWidth, $cartImageHeight);
$url       = UsniAdaptor::createUrl('catalog/products/site/detail', ['id' => $product_id]);
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
    <td class="text-left"><?php echo $selectedOptions;?></td>
    <td class="text-left">
        <div class="input-group btn-block" style="max-width: 200px;">
            <input type="text" name="quantity[<?php echo $item_code;?>]" value="<?php echo $qty;?>" size="1" class="form-control cart-qty">
            <span class="input-group-btn">
                <button type="button" title="" class="btn btn-success btn-sm cart-update" data-itemcode = "<?php echo $item_code;?>" id="refresh-<?php echo $item_code;?>">
                    <?php echo FA::icon('refresh');?>
                </button>
                <button type="button" title="" class="btn btn-danger btn-sm cart-remove" data-itemcode = "<?php echo $item_code;?>" id="remove-<?php echo $item_code;?>">
                    <?php echo FA::icon('times-circle');?>
                </button>
            </span>
        </div>
        <div class="input-error" style="display:none"></div>
    </td>
    <td class="text-right"><?php echo ProductUtil::getFormattedPrice($price);?></td>
    <td class="text-right"><?php echo ProductUtil::getFormattedPrice($tax);?></td>
    <td class="text-right"><?php echo ProductUtil::getFormattedPrice($total_price * $qty);?></td>
</tr>