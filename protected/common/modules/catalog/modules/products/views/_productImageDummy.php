<?php
use usni\UsniAdaptor;
use usni\library\utils\Html;
?>
<table style="display: none;">
    <tr class="productimage-value-row-dummy">
        <?php echo Html::hiddenInput('ProductImage[##dummyindex##][id]', '-1');?>
        <td class="text-left">
            <input type="text" name="ProductImage[##dummyindex##][caption]" value="" placeholder="<?php echo UsniAdaptor::t('products', 'Caption');?>" class="form-control">
        </td>
        <td class="text-right">
            <?php echo Html::fileInput("ProductImage[##dummyindex##][uploadInstance]", null, ['placeholder' => UsniAdaptor::t('application', 'Image'), 'class' => 'form-control']);?>
        </td>
        <td class="text-right">
            <button type="button" onclick="$(this).tooltip('destroy');
                        $(this).closest('.productimage-value-row').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="<?php echo UsniAdaptor::t('products', 'Remove');?>">
                <i class="fa fa-minus-circle"></i>
            </button>
        </td>
    </tr>
</table>