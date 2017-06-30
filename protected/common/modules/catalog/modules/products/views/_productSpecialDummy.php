<?php
use usni\UsniAdaptor;
use usni\library\utils\Html;
?>
<table style="display: none;">
    <tr class="special-value-row-dummy">
        <td class="text-left">
            <?php echo Html::dropDownList('ProductSpecial[##rowCount##][group_id_dummy]', null, $groups, ['class' => 'form-control dummy-special']); ?>
        </td>
        <td class="text-right">
            <input type="text" name="ProductSpecial[##rowCount##][priority]" value="" placeholder="<?php echo UsniAdaptor::t('products', 'Priority');?>" class="form-control">
        </td>
        <td class="text-left">
            <input type="text" name="ProductSpecial[##rowCount##][price]" value="" placeholder="<?php echo UsniAdaptor::t('products', 'Price');?>" class="form-control">
        </td>
        <td class="text-right">
            <input type="text" name="ProductSpecial[##rowCount##][start_datetime]" value="" placeholder="YYYY-mm-dd H:i:s" class="form-control datefield">
        </td>
        <td class="text-left">
            <input type="text" name="ProductSpecial[##rowCount##][end_datetime]" value="" placeholder="YYYY-mm-dd H:i:s" class="form-control datefield">
        </td>
        <td class="text-right">
            <button type="button" onclick="$(this).tooltip('destroy');
                        $(this).closest('.special-value-row').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="<?php echo UsniAdaptor::t('products', 'Remove');?>">
                <i class="fa fa-minus-circle"></i>
            </button>
        </td>
    </tr>
</table>