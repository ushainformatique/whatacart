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
</table>

