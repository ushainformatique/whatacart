<?php
use usni\UsniAdaptor;
use products\utils\ProductUtil;
use common\utils\ApplicationUtil;

extract($data);
$thumbnail = ApplicationUtil::getImage($thumbnail, 'cart', 55, 55);
$url       = UsniAdaptor::createUrl('catalog/products/site/detail', ['id' => $product_id]);
?>
<tr>
    <td class="text-center">                  
        <a href="<?php echo $url;?>"><?php echo $thumbnail;?></a>
    </td>
    <td class="text-left">
        <?php
            echo ProductUtil::renderOutOfStockMessage($name, $stock_status);
        ?>
    </td>
    <td class="text-left"><?php echo $model;?></td>
    <td class="text-left"><?php echo $selectedOptions;?></td>
    <td class="text-left"><?php echo $qty;?></td>
    <td class="text-right"><?php echo ProductUtil::getFormattedPrice($price);?></td>
    <td class="text-right"><?php echo ProductUtil::getFormattedPrice($tax);?></td>
    <td class="text-right"><?php echo ProductUtil::getFormattedPrice($total_price * $qty);?></td>
</tr>