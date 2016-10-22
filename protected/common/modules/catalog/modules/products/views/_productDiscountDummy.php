<?php
use usni\UsniAdaptor;
?>
<table style="display: none;">
    <tr class="discount-value-row-dummy">
        <td class="text-left">
            <?php echo $dropdown; ?>
        </td>
        <td class="text-right">
            <input type="text" name="ProductDiscount[quantity][]" value="" placeholder="<?php echo UsniAdaptor::t('products', 'Quantity');?>" class="form-control">
        </td>
        <td class="text-left">
            <input type="text" name="ProductDiscount[priority][]" value="" placeholder="<?php echo UsniAdaptor::t('products', 'Priority');?>" class="form-control">
        </td>
        <td class="text-right">
            <input type="text" name="ProductDiscount[price][]" value="" placeholder="<?php echo UsniAdaptor::t('products', 'Price');?>" class="form-control">
        </td>
        <td class="text-left">
            <input type="text" name="ProductDiscount[start_datetime][]" value="" placeholder="YYYY-mm-dd H:i:s" class="form-control datefield">
        </td>
        <td class="text-right">
            <input type="text" name="ProductDiscount[end_datetime][]" value="" placeholder="YYYY-mm-dd H:i:s" class="form-control datefield">
        </td>
        <td class="text-left">
            <button type="button" onclick="$(this).tooltip('destroy');
                        $(this).closest('.discount-value-row').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="<?php echo UsniAdaptor::t('products', 'Remove');?>">
                <i class="fa fa-minus-circle"></i>
            </button>
        </td>
    </tr>
</table>