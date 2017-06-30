<?php
use usni\UsniAdaptor;
use usni\library\utils\Html;
?>
<table style="display: none;">
    <tr class="discount-value-row-dummy">
        <td class="text-left">
            <?php echo Html::dropDownList('ProductDiscount[##rowCount##][group_id_dummy]', null, $groups, ['class' => 'form-control dummy-discount']); ?>
        </td>
        <td class="text-right">
            <input type="text" name="ProductDiscount[##rowCount##][quantity]" value="" placeholder="<?php echo UsniAdaptor::t('products', 'Quantity');?>" class="form-control">
        </td>
        <td class="text-left">
            <input type="text" name="ProductDiscount[##rowCount##][priority]" value="" placeholder="<?php echo UsniAdaptor::t('products', 'Priority');?>" class="form-control">
        </td>
        <td class="text-right">
            <input type="text" name="ProductDiscount[##rowCount##][price]" value="" placeholder="<?php echo UsniAdaptor::t('products', 'Price');?>" class="form-control">
        </td>
        <td class="text-left">
            <input type="text" name="ProductDiscount[##rowCount##][start_datetime]" value="" placeholder="YYYY-mm-dd H:i:s" class="form-control datefield">
        </td>
        <td class="text-right">
            <input type="text" name="ProductDiscount[##rowCount##][end_datetime]" value="" placeholder="YYYY-mm-dd H:i:s" class="form-control datefield">
        </td>
        <td class="text-left">
            <button type="button" onclick="$(this).tooltip('destroy');
                        $(this).closest('.discount-value-row').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="<?php echo UsniAdaptor::t('products', 'Remove');?>">
                <i class="fa fa-minus-circle"></i>
            </button>
        </td>
    </tr>
</table>