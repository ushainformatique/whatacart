<?php
use usni\fontawesome\FA;
use usni\UsniAdaptor;
use frontend\widgets\OutOfStockBadge;

/*
 * @var $this \frontend\web\View
 */

$thumbnail      = $this->renderImageByStoreSettings($item, 'thumbnail', 'cart', 55, 55);
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
    <td class="text-left"><?php echo $item->displayedOptions;?></td>
    <td class="text-left">
        <?php
        if(!$isConfirm)
        {
        ?>
            <div class="input-group btn-block" style="max-width: 200px;">
                <input type="text" name="quantity[<?php echo $item->itemCode;?>]" value="<?php echo $item->qty;?>" size="1" class="form-control cart-qty">
                <span class="input-group-btn">
                    <button type="button" title="" class="btn btn-success btn-sm cart-update" data-itemcode = "<?php echo $item->itemCode;?>" id="refresh-<?php echo $item->itemCode;?>">
                        <?php echo FA::icon('refresh');?>
                    </button>
                    <button type="button" title="" class="btn btn-danger btn-sm cart-remove" data-itemcode = "<?php echo $item->itemCode;?>" id="remove-<?php echo $item->itemCode;?>">
                        <?php echo FA::icon('times-circle');?>
                    </button>
                </span>
            </div>
            <div class="input-error" style="display:none"></div>
        <?php
        }
        else
        {
            echo $item->qty;
        }
        ?>
    </td>
    <td class="text-right"><?php echo $this->getFormattedPrice($item->price, $currencyCode);?></td>
    <td class="text-right"><?php echo $this->getFormattedPrice($item->tax, $currencyCode);?></td>
    <td class="text-right"><?php echo $this->getFormattedPrice($item->totalPrice * $item->qty, $currencyCode);?></td>
</tr>