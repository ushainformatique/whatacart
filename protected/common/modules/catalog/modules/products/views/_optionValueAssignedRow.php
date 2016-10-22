<?php
use usni\UsniAdaptor;
use products\models\ProductOptionValue;

extract($optionValueRecord);
if($includeHeader)
{
?>
    <tr>
        <td><?php echo ProductOptionValue::getLabel(1);?></td>
        <td><?php echo UsniAdaptor::t('products', 'Quantity');?></td>
        <td><?php echo UsniAdaptor::t('products', 'Subtract Stock');?></td>
        <td><?php echo UsniAdaptor::t('products', 'Price');?></td>
        <td><?php echo UsniAdaptor::t('products', 'Weight');?></td>
        <?php
        if($shouldRenderActionColumn)
        {
        ?>
            <td><?php echo UsniAdaptor::t('application', 'Action');?></td>
        <?php
        }
        ?>
    </tr>
<?php
}
?>
<tr class="option-value-row-<?php echo $option_value_id;?>">
    <td>
        <?php echo $option_value_name; ?>
    </td>
    <td>
        <?php echo $quantity;?>
    </td>
    <td>
        <?php echo $subtract_stock == 1 ? UsniAdaptor::t('application', 'Yes'): UsniAdaptor::t('application', 'No');?>
    </td>
    <td>
        <?php echo $price_prefix . $price;?> 
    </td>
    <td>
        <?php echo $weight_prefix . $weight;?> 
    </td>
    <?php
        //This might not be required but just keep it.
        if($shouldRenderActionColumn)
        {
        ?>
            <td>
                <button type="button" onclick="$(this).tooltip('destroy');
                            $('.option-value-row-<?php echo $option_value_id;?>').remove();$(this).removeProductOption('<?php echo $deleteUrl;?>', '<?php echo $id;?>');" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="<?php echo UsniAdaptor::t('products', 'Remove');?>">
                    <i class="fa fa-minus-circle"></i>
                </button>
            </td>
    <?php
        }
    ?>
</tr>