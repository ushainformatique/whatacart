<?php
use usni\UsniAdaptor;
use products\behaviors\PriceBehavior;

/* @var $this \usni\library\web\AdminView */
$this->attachBehavior('priceBehavior', PriceBehavior::className());

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
    <td style="<?php echo $tdStyle;?>"><?php echo $this->getPriceWithSymbol($price, $currencySymbol);?></td>
    <td style="<?php echo $tdStyle;?>"><?php echo $this->getPriceWithSymbol($tax, $currencySymbol);?></td>
    <td style="<?php echo $tdStyle;?>"><?php echo $this->getPriceWithSymbol($total, $currencySymbol);?></td>
</tr>