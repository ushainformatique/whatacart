<?php
use usni\fontawesome\FA;
use usni\UsniAdaptor;
use frontend\widgets\OutOfStockBadge;
use products\behaviors\PriceBehavior;

/* @var $this \usni\library\web\AdminView */

$this->attachBehavior('priceBehavior', PriceBehavior::className());

$thumbnail      = $this->renderImageByStoreSettings($item, 'thumbnail', 'cart', 55, 55);
$url            = UsniAdaptor::createUrl('catalog/products/site/detail', ['id' => $item->productId]);
?>
<tr>
    <td class="text-center">                  
        <a href="<?php echo $url;?>"><?php echo $thumbnail;?></a>
    </td>
    <td>
        <a href="<?php echo $url;?>">
            <?php
                echo OutOfStockBadge::widget(['name' => $item->name, 'stockStatus' => $item->stockStatus]);
            ?>
        </a>
    </td>
    <td><?php echo $item->model;?></td>
    <td><?php echo $item->displayedOptions;?></td>
    <td><?php echo $item->qty;?></td>
    <td><?php echo $this->getFormattedPrice($item->price, $currencyCode);?></td>
    <td><?php echo $this->getFormattedPrice($item->tax, $currencyCode);?></td>
    <td><?php echo $this->getFormattedPrice($item->totalPrice * $item->qty, $currencyCode);?></td>
    <?php
    if(!$isConfirm)
    {
    ?>
    <td class="remove">
        <div class="input-group btn-block" style="max-width: 50px;">
            <span class="input-group-btn">
                <button type="button" title="" class="btn btn-danger order-cart-remove" data-itemcode = "<?php echo $item->itemCode;?>">
                    <?php echo FA::icon('times-circle');?>
                </button>
            </span>
        </div>
    </td>
    <?php
    }
    ?>
</tr>