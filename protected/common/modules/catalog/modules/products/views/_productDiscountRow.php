<?php
use usni\UsniAdaptor;
?>
<tr class="discount-value-row" id="discount-value-row-<?php echo $index;?>">
    <td class="text-left">
        <?php echo $dropdown; ?>
    </td>
    <td class="text-right">
        <input type="text" name="ProductDiscount[<?php echo $index;?>][quantity]';?>" value="<?php echo $quantity;?>" placeholder="<?php echo UsniAdaptor::t('products', 'Quantity');?>" class="form-control">
    </td>
    <td class="text-left">
        <input type="text" name="ProductDiscount[<?php echo $index;?>][priority]" value="<?php echo $priority;?>" placeholder="<?php echo UsniAdaptor::t('products', 'Priority');?>" class="form-control">
    </td>
    <td class="text-right">
        <input type="text" name="ProductDiscount[<?php echo $index;?>][price]" value="<?php echo $price;?>" placeholder="<?php echo UsniAdaptor::t('products', 'Price');?>" class="form-control">
    </td>
    <td class="text-left">
        <input type="text" name="ProductDiscount[<?php echo $index;?>][start_datetime]" value="<?php echo $start_datetime;?>" placeholder="<?php echo UsniAdaptor::t('products', 'Start Datetime');?>" class="form-control datefield">
    </td>
    <td class="text-right">
        <input type="text" name="ProductDiscount[<?php echo $index;?>][end_datetime]" value="<?php echo $end_datetime;?>" placeholder="<?php echo UsniAdaptor::t('products', 'End Datetime');?>" class="form-control datefield">
    </td>
    <td class="text-left">
        <button type="button" id="remove-discount-value-row" onclick="$(this).tooltip('destroy');
            $(this).closest('.discount-value-row').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="<?php echo UsniAdaptor::t('products', 'Remove');?>" id="remove">
            <i class="fa fa-minus-circle"></i>
        </button>
    </td>
</tr>