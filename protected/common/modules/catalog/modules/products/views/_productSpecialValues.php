<?php
use usni\UsniAdaptor;
?>
<table id="special-value-table" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <td class="text-left"><?php echo UsniAdaptor::t('customer', 'Customer Group');?></td>
            <td class="text-right"><?php echo UsniAdaptor::t('products', 'Priority');?></td>
            <td class="text-left"><?php echo UsniAdaptor::t('products', 'Price');?></td>
            <td class="text-right"><?php echo UsniAdaptor::t('products', 'Start Date');?></td>
            <td class="text-left"><?php echo UsniAdaptor::t('products', 'End Date');?></td>
            <td class="text-right"></td>
        </tr>
    </thead>
    <tbody>
        <?php echo $rows;?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5"></td>
            <td class="text-left">
                <button type="button" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="<?php echo UsniAdaptor::t('products', 'Add Special');?>" id="add-special-value-row">
                    <i class="fa fa-plus-circle"></i>
                </button>
            </td>
        </tr>
    </tfoot>
</table>

