<?php
use usni\UsniAdaptor;
?>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th><?php echo UsniAdaptor::t('products', 'SKU'); ?></th>
            <th><?php echo UsniAdaptor::t('application', 'Name'); ?></th>
            <th><?php echo UsniAdaptor::t('products', 'Options') ?></th>
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
                <td><?php echo $orderProduct['displayed_options'];?></td>
                <td><?php echo $orderProduct['quantity']; ?></td>
                <td><?php echo $this->getPriceWithSymbol($orderProduct['price'], $currencySymbol); ?></td>
                <td><?php echo $this->getPriceWithSymbol($orderProduct['tax'], $currencySymbol); ?></td>
                <td><?php echo $this->getPriceWithSymbol($orderProduct['total'], $currencySymbol); ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>