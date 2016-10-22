<?php
use usni\UsniAdaptor;
use products\utils\ProductUtil;

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
    <td><?php echo ProductUtil::getPriceWithSymbol($price, $currencyCode);?></td>
    <td><?php echo ProductUtil::getPriceWithSymbol($tax, $currencyCode);?></td>
    <td><?php echo ProductUtil::getPriceWithSymbol($total, $currencyCode);?></td>
</tr>