<?php
use usni\UsniAdaptor;

/* @var $this \usni\library\web\AdminView */

extract($data);
$url       = UsniAdaptor::createUrl('catalog/products/site/detail', ['id' => $product_id]);
?>
<tr>
    <td>
        <a href="<?php echo $url;?>"><?php echo $name;?></a>
    </td>
    <td><?php echo $model;?></td>
    <td><?php echo $displayed_options;?></td>
    <td>
        <?php echo $quantity;?>
    </td>
    <td><?php echo $this->getPriceWithSymbol($price, $currencySymbol);?></td>
    <td><?php echo $this->getPriceWithSymbol($tax, $currencySymbol);?></td>
    <td><?php echo $this->getPriceWithSymbol($total, $currencySymbol);?></td>
</tr>