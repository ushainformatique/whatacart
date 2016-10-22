<?php
use usni\UsniAdaptor;
use products\utils\ProductUtil;
?>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th><?php echo UsniAdaptor::t('products', 'SKU'); ?></th>
            <th><?php echo UsniAdaptor::t('application', 'Name'); ?></th>
            <th><?php echo UsniAdaptor::t('products', 'Quantity'); ?></th>
            <th><?php echo UsniAdaptor::t('products', 'Price'); ?></th>
            <th><?php echo UsniAdaptor::t('tax', 'Tax');    ?></th>
            <th><?php echo UsniAdaptor::t('application', 'Total'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($orderProducts as $orderProduct)
        {
            ?>
            <tr>
                <td><?php echo $orderProduct['sku']; ?></td>
                <td><?php echo $orderProduct['name']; ?></td>
                <td><?php echo $orderProduct['quantity']; ?></td>
                <td><?php echo ProductUtil::getPriceWithSymbol($orderProduct['price'], $currencyCode); ?></td>
                <td><?php echo ProductUtil::getPriceWithSymbol($orderProduct['tax'], $currencyCode); ?></td>
                <td><?php echo ProductUtil::getPriceWithSymbol($orderProduct['total'], $currencyCode); ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>