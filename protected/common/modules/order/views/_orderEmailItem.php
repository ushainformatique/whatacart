<?php
use usni\UsniAdaptor;
use products\utils\ProductUtil;

extract($data);
$url       = UsniAdaptor::app()->getFrontUrl() . '/catalog/products/site/detail?id=' . $product_id;
$tdStyle   = "font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;";
?>
<tr>
    <td style="<?php echo $tdStyle;?>">
        <a href="<?php echo $url;?>"><?php echo $name;?></a>
    </td>
    <td style="<?php echo $tdStyle;?>"><?php echo $model;?></td>
    <td style="<?php echo $tdStyle;?>"><?php echo $displayed_options;?></td>
    <td style="<?php echo $tdStyle;?>">
        <?php echo $quantity;?>
    </td>
    <td style="<?php echo $tdStyle;?>"><?php echo ProductUtil::getPriceWithSymbol($price, $currencyCode);?></td>
    <td style="<?php echo $tdStyle;?>"><?php echo ProductUtil::getPriceWithSymbol($tax, $currencyCode);?></td>
    <td style="<?php echo $tdStyle;?>"><?php echo ProductUtil::getPriceWithSymbol($total, $currencyCode);?></td>
</tr>