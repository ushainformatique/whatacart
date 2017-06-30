<?php
use usni\fontawesome\FA;
use usni\UsniAdaptor;
use frontend\widgets\OutOfStockBadge;
/*
 * @var $this \frontend\web\View
 */
$thumbnail = $this->renderImageByStoreSettings($item, 'thumbnail', 'cart', 55, 55);
$url       = UsniAdaptor::createUrl('catalog/products/site/detail', ['id' => $item->productId]);
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
        <?php
        if($item->displayedOptions != null)
        {
            echo "<br><small>" . $item->displayedOptions . "</small>";
        }
        ?>
    </td>
    <td class="text-right">
        x <?php echo $item->qty;?>
    </td>
    <td class="text-right"><?php echo $this->getFormattedPrice($item->totalPrice * $item->qty, $currencyCode);?></td>
    <td class="text-center">
        <a href="#" class="cart-remove" data-itemcode = "<?php echo $item->itemCode;?>" title="<?php echo UsniAdaptor::t('application', 'Remove');?>">
            <?php echo FA::icon('close');?>
        </a>
    </td>
</tr>