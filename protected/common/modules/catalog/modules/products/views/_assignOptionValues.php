<?php
use usni\UsniAdaptor;
use products\models\ProductOptionValue;
?>
<table id="option-value-table" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <td class="text-left"><?php echo ProductOptionValue::getLabel(1);?></td>
            <td class="text-right"><?php echo UsniAdaptor::t('products', 'Quantity');?></td>
            <td class="text-left"><?php echo UsniAdaptor::t('products', 'Subtract Stock');?></td>
            <td class="text-right"><?php echo UsniAdaptor::t('products', 'Price');?></td>
            <td class="text-right"><?php echo UsniAdaptor::t('products', 'Weight');?></td>
            <td class="text-right"><?php echo UsniAdaptor::t('application', 'Action');?></td>
        </tr>
    </thead>
    <tbody>
        <?php echo $rows;?>
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

