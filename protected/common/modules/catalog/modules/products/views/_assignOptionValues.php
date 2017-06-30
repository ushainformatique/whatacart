<?php
use usni\UsniAdaptor;
use usni\library\utils\Html;
use usni\library\utils\ArrayUtil;

$items        = ArrayUtil::map($optionValues, 'id', 'value');
?>
<table id="option-value-table" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <td class="text-left"><?php echo UsniAdaptor::t('products', 'Option Value');?></td>
            <td class="text-right"><?php echo UsniAdaptor::t('products', 'Quantity');?></td>
            <td class="text-left"><?php echo UsniAdaptor::t('products', 'Subtract Stock');?></td>
            <td class="text-right"><?php echo UsniAdaptor::t('products', 'Price');?></td>
            <td class="text-right"><?php echo UsniAdaptor::t('products', 'Weight');?></td>
            <td class="text-right"><?php echo UsniAdaptor::t('application', 'Action');?></td>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($assignedOptionsMapping as $index => $optionMapping)
            {
        ?>
                <tr id="option-value-row-<?php echo $index;?>" class="option-value-row">
                    <td class="text-left">
                        <?php echo Html::dropDownList('ProductOptionMapping[option_value_id][]', $optionMapping['option_value_id'], $items, ['class' => 'form-control']);?>
                    </td>
                    <td class="text-right">
                        <input type="text" name="ProductOptionMapping[quantity][]" value="<?php echo $optionMapping['quantity'];?>" placeholder="<?php echo UsniAdaptor::t('products', 'Quantity');?>" class="form-control">
                    </td>
                    <td class="text-left">
                        <?php echo Html::dropDownList('ProductOptionMapping[subtract_stock][]', 
                                                        $optionMapping['subtract_stock'], 
                                                        ['1' => UsniAdaptor::t('application', 'Yes'),
                                                         '0' => UsniAdaptor::t('application', 'No')],
                                                        ['class' => 'form-control']
                                                       )
                        ?>
                    </td>
                    <td class="text-right">
                        <?php echo Html::dropDownList('ProductOptionMapping[price_prefix][]', 
                                                        $optionMapping['price_prefix'], 
                                                        ['+' => '+',
                                                         '-' => '-'],
                                                        ['class' => 'form-control']
                                                       )
                        ?>
                        <input type="text" name="ProductOptionMapping[price][]" value="<?php echo $optionMapping['price'];?>" placeholder="<?php echo UsniAdaptor::t('products', 'Price');?>" class="form-control"></td>
                    <td class="text-right">
                        <?php echo Html::dropDownList('ProductOptionMapping[weight_prefix][]', 
                                                        $optionMapping['weight_prefix'], 
                                                        ['+' => '+',
                                                         '-' => '-'],
                                                        ['class' => 'form-control']
                                                       )
                        ?>
                        <input type="text" name="ProductOptionMapping[weight][]" value="<?php echo $optionMapping['weight'];?>" placeholder="<?php echo UsniAdaptor::t('products', 'Weight');?>" class="form-control"></td>
                    <td class="text-right">
                        <button type="button" id="remove-option-value-row" onclick="$(this).tooltip('destroy');
                            $(this).closest('.option-value-row').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="<?php echo UsniAdaptor::t('products', 'Remove');?>">
                                <i class="fa fa-minus-circle"></i>
                        </button>
                    </td>
                </tr>
                <?php
            }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6" class="text-right">
                <button type="button" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="<?php echo UsniAdaptor::t('products', 'Add Option Value');?>" id="add-option-value-row">
                    <i class="fa fa-plus-circle"></i>
                </button>
            </td>
        </tr>
    </tfoot>
</table>
<?php
echo $this->render('/_assignOptionValuesDummy', ['items' => $items]);
