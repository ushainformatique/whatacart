<?php
use usni\UsniAdaptor;
?>
<table id="productimage-value-table" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <td class="text-left"><?php echo UsniAdaptor::t('products', 'Caption');?></td>
            <td class="text-right"><?php echo UsniAdaptor::t('application', 'Image');?></td>
            <td></td>
        </tr>
    </thead>
    <tbody>
        <?php echo $rows;?>
    </tbody>
    <tfoot>
        <tr>
            <td class="text-right" colspan="3">
                <button type="button" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="<?php echo UsniAdaptor::t('products', 'Add Image');?>" id="add-productimage-value-row">
                    <i class="fa fa-plus-circle"></i>
                </button>
            </td>
        </tr>
    </tfoot>
</table>

