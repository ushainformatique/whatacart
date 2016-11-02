<?php
use usni\UsniAdaptor;
?>
<tr class="special-value-row" id="special-value-row-<?php echo $index;?>">
    <td class="text-left">
        <?php echo $dropdown; ?>
    </td>
    <td class="text-right">
        <input type="text" name="ProductSpecial[<?php echo $index;?>][priority]" value="<?php echo $priority;?>" placeholder="<?php echo UsniAdaptor::t('products', 'Priority');?>" class="form-control">
    </td>
    <td class="text-left">
        <input type="text" name="ProductSpecial[<?php echo $index;?>][price]" value="<?php echo $price;?>" placeholder="<?php echo UsniAdaptor::t('products', 'Price');?>" class="form-control">
    </td>
    <td class="text-right">
        <input type="text" name="ProductSpecial[<?php echo $index;?>][start_datetime]" value="<?php echo $start_datetime;?>" placeholder="<?php echo UsniAdaptor::t('products', 'Start Datetime');?>" class="form-control datefield">
    </td>
    <td class="text-left">
        <input type="text" name="ProductSpecial[<?php echo $index;?>][end_datetime]" value="<?php echo $end_datetime;?>" placeholder="<?php echo UsniAdaptor::t('products', 'End Datetime');?>" class="form-control datefield">
    </td>
    <td class="text-right">
        <button type="button" id="remove-special-value-row" onclick="$(this).tooltip('destroy');
                    $(this).closest('.special-value-row').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="<?php echo UsniAdaptor::t('products', 'Remove');?>">
            <i class="fa fa-minus-circle"></i>
        </button>
    </td>
</tr>