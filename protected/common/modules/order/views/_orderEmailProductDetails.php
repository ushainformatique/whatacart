<?php
use usni\UsniAdaptor;
use products\utils\ProductUtil;
$tdHeaderStyle = "font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;";
$tdColumnStyle = "font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; font-weight: bold; text-align: left; padding: 7px; color: #222222;";
?>
<table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
    <thead>
        <tr>
            <td style="<?php echo $tdHeaderStyle;?>"><?php echo UsniAdaptor::t('application', 'Name') ?></td>
            <td style="<?php echo $tdHeaderStyle;?>"><?php echo UsniAdaptor::t('products', 'Model') ?></td>
            <td style="<?php echo $tdHeaderStyle;?>"><?php echo UsniAdaptor::t('products', 'Options') ?></td>
            <td style="<?php echo $tdHeaderStyle;?>"><?php echo UsniAdaptor::t('products', 'Quantity') ?></td>
            <td style="<?php echo $tdHeaderStyle;?>"><?php echo UsniAdaptor::t('products', 'Unit Price') ?></td>
            <td style="<?php echo $tdHeaderStyle;?>"><?php echo UsniAdaptor::t('tax', 'Tax') ?></td>
            <td style="<?php echo $tdHeaderStyle;?>"><?php echo UsniAdaptor::t('products', 'Total Price') ?></td>
        </tr>
    </thead>
    <tbody>
        <?php
        echo $items;
        ?>
    </tbody>
</table>
<br/>
<table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
    <tbody>
        <tr>
            <td style="<?php echo $tdColumnStyle;?>"><strong><?php echo UsniAdaptor::t('products', 'Sub-Total'); ?></strong></td>
            <td style="<?php echo $tdColumnStyle;?>"><?php echo ProductUtil::getPriceWithSymbol($totalUnitPrice, $currencyCode); ?></td>
        </tr>
        <tr>
            <td style="<?php echo $tdColumnStyle;?>"><strong><?php echo UsniAdaptor::t('tax', 'Tax'); ?></strong></td>
            <td style="<?php echo $tdColumnStyle;?>"><?php echo ProductUtil::getPriceWithSymbol($totalTax, $currencyCode); ?></td>
        </tr>
        <?php
        if ($shippingPrice > 0)
        {
            ?>
            <tr>
                <td style="<?php echo $tdColumnStyle;?>"><strong><?php echo UsniAdaptor::t('shipping', 'Shipping Cost'); ?></strong></td>
                <td style="<?php echo $tdColumnStyle;?>"><?php echo ProductUtil::getPriceWithSymbol($shippingPrice, $currencyCode); ?></td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td style="<?php echo $tdColumnStyle;?>"><strong><?php echo UsniAdaptor::t('application', 'Total'); ?></strong></td>
            <td style="<?php echo $tdColumnStyle;?>"><?php echo ProductUtil::getPriceWithSymbol($totalPrice, $currencyCode); ?></td>
        </tr>
    </tbody>
</table>