<?php
use usni\library\components\UiHtml;
use usni\UsniAdaptor;
?>
<tr id="option-value-row-<?php echo $index;?>" class="option-value-row">
    <td class="text-left">
        <?php echo $dropdown;?>
    </td>
    <td class="text-right">
        <input type="text" name="ProductOptionMapping[quantity][]" value="<?php echo $quantity;?>" placeholder="<?php echo UsniAdaptor::t('products', 'Quantity');?>" class="form-control">
    </td>
    <td class="text-left">
        <?php echo UiHtml::dropDownList('ProductOptionMapping[subtract_stock][]', 
                                        $subtract_stock, 
                                        ['1' => UsniAdaptor::t('application', 'Yes'),
                                         '0' => UsniAdaptor::t('application', 'No')],
                                        ['class' => 'form-control']
                                       )
        ?>
    </td>
    <td class="text-right">
        <?php echo UiHtml::dropDownList('ProductOptionMapping[price_prefix][]', 
                                        $price_prefix, 
                                        ['+' => '+',
                                         '-' => '-'],
                                        ['class' => 'form-control']
                                       )
        ?>
        <input type="text" name="ProductOptionMapping[price][]" value="<?php echo $price;?>" placeholder="<?php echo UsniAdaptor::t('products', 'Price');?>" class="form-control"></td>
    <td class="text-right">
        <?php echo UiHtml::dropDownList('ProductOptionMapping[weight_prefix][]', 
                                        $weight_prefix, 
                                        ['+' => '+',
                                         '-' => '-'],
                                        ['class' => 'form-control']
                                       )
        ?>
        <input type="text" name="ProductOptionMapping[weight][]" value="<?php echo $weight;?>" placeholder="<?php echo UsniAdaptor::t('products', 'Weight');?>" class="form-control"></td>
    <td class="text-right">
        <button type="button" id="remove-option-value-row" onclick="$(this).tooltip('destroy');
            $(this).closest('.option-value-row').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="<?php echo UsniAdaptor::t('products', 'Remove');?>">
                <i class="fa fa-minus-circle"></i>
        </button>
    </td>
</tr>