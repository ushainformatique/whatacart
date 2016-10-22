<?php
use usni\UsniAdaptor;
use products\utils\ProductUtil;
use common\utils\ApplicationUtil;

extract($data);
$url       = UsniAdaptor::createUrl('catalog/products/site/detail', ['id' => $product_id]);
$thumbnail = ApplicationUtil::getImage($thumbnail, 'cart', 55, 55);
?>
<tr>
    <td class="text-center">                  
        <a href="<?php echo $url;?>"><?php echo $thumbnail;?></a>
    </td>
    <td>
        <a href="<?php echo $url;?>">
            <?php
                echo ProductUtil::renderOutOfStockMessage($name, $stock_status);
            ?>
        </a>
    </td>
    <td><?php echo $model;?></td>
    <td><?php echo $selectedOptions;?></td>
    <td>
        <?php echo $qty;?>
    </td>
    <td><?php echo ProductUtil::getFormattedPrice($price, $currencyCode);?></td>
    <td><?php echo ProductUtil::getFormattedPrice($tax, $currencyCode);?></td>
    <td><?php echo ProductUtil::getFormattedPrice($total_price * $qty, $currencyCode);?></td>
</tr>