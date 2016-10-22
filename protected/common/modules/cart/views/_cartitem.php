<?php
use usni\fontawesome\FA;
use usni\UsniAdaptor;
use products\utils\ProductUtil;
use common\utils\ApplicationUtil;

extract($data);
$url       = UsniAdaptor::createUrl('catalog/products/default/view', ['id' => $product_id]);
$thumbnail = ApplicationUtil::getImage($thumbnail, 'cart', 55, 55);
?>
<tr>
    <td class="text-center">                  
        <a href="<?php echo $url;?>"><?php echo $thumbnail;?></a>
    </td>
    <td>
        <a href="<?php echo $url;?>">
            <?php
            if($stock_status == ProductUtil::OUT_OF_STOCK)
            {
                echo $name . '<span class="badge">' . UsniAdaptor::t('products', 'Out of Stock') . "</span>";
            }
            else
            {
               echo $name; 
            }
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
    <td class="remove">
        <div class="input-group btn-block" style="max-width: 50px;">
            <span class="input-group-btn">
                <button type="button" title="" class="btn btn-danger order-cart-remove" data-itemcode = "<?php echo $item_code;?>">
                    <?php echo FA::icon('times-circle');?>
                </button>
            </span>
        </div>
    </td>
</tr>