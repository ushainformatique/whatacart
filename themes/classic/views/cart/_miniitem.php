<?php
use usni\fontawesome\FA;
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
        <a href="<?php echo $url;?>">
            <?php
                echo ProductUtil::renderOutOfStockMessage($name, $stock_status);
            ?>
        </a>
        <?php
        if($selectedOptions != null)
        {
            echo "<br><small>" . $selectedOptions . "</small>";
        }
        ?>
    </td>
    <td class="text-right">
        x <?php echo $qty;?>
    </td>
    <td class="text-right"><?php echo ProductUtil::getFormattedPrice($total_price * $qty);?></td>
    <td class="text-center">
        <a href="#" class="cart-remove" data-itemcode = "<?php echo $item_code;?>" title="<?php echo UsniAdaptor::t('application', 'Remove');?>">
            <?php echo FA::icon('close');?>
        </a>
    </td>
</tr>