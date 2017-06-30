<?php
use usni\UsniAdaptor;

/* @var $formDTO \products\dto\FormDTO */
/* @var $form \usni\library\bootstrap\ActiveForm */

$productDiscounts   = $formDTO->discounts;
$errors             = $formDTO->model->getErrors('discounts');
if(!empty($errors))
{
?>
<div class="alert alert-danger">
    <?php echo implode('<br/>', $errors);?>
</div>
<?php
}
?>
<table id="discount-value-table" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <td class="text-left"><?php echo UsniAdaptor::t('customer', 'Customer Group');?></td>
            <td class="text-right"><?php echo UsniAdaptor::t('products', 'Quantity');?></td>
            <td class="text-left"><?php echo UsniAdaptor::t('products', 'Priority');?></td>
            <td class="text-right"><?php echo UsniAdaptor::t('products', 'Price');?></td>
            <td class="text-left"><?php echo UsniAdaptor::t('products', 'Start Date');?></td>
            <td class="text-right"><?php echo UsniAdaptor::t('products', 'End Date');?></td>
            <td class="text-left"></td>
        </tr>
    </thead>
    <tbody>
        <?php
        if(!empty($productDiscounts))
        {
            foreach($productDiscounts as $index => $discount)
            {
                ?>
                <tr class="discount-value-row" id="discount-value-row-<?php echo $index;?>">
                    <td class="text-left">
                        <?= $form->field($discount, "[$index]group_id")->dropDownList($formDTO->getGroups())->label(false);?>
                    </td>
                    <td class="text-right">
                        <?= $form->field($discount, "[$index]quantity")->textInput(['placeholder' => UsniAdaptor::t('products', 'Quantity')])->label(false);?>
                    </td>
                    <td class="text-left">
                        <?= $form->field($discount, "[$index]priority")->textInput(['placeholder' => UsniAdaptor::t('products', 'Priority')])->label(false);?>
                    </td>
                    <td class="text-right">
                        <?= $form->field($discount, "[$index]price")->textInput(['placeholder' => UsniAdaptor::t('products', 'Price')])->label(false);?>
                    </td>
                    <td class="text-left">
                        <?= $form->field($discount, "[$index]start_datetime", ['inputOptions' => ['class' => 'form-control datefield']])->textInput(['placeholder' => UsniAdaptor::t('products', 'Start Datetime')])->label(false);?>
                    </td>
                    <td class="text-right">
                        <?= $form->field($discount, "[$index]end_datetime", ['inputOptions' => ['class' => 'form-control datefield']])->textInput(['placeholder' => UsniAdaptor::t('products', 'End Datetime')])->label(false);?>
                    </td>
                    <td class="text-left">
                        <button type="button" id="remove-discount-value-row" onclick="$(this).tooltip('destroy');
                            $(this).closest('.discount-value-row').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="<?php echo UsniAdaptor::t('products', 'Remove');?>" id="remove">
                            <i class="fa fa-minus-circle"></i>
                        </button>
                    </td>
                </tr>
            <?php
            }
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6"></td>
            <td class="text-left">
                <button type="button" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="<?php echo UsniAdaptor::t('products', 'Add Discount');?>" id="add-discount-value-row">
                    <i class="fa fa-plus-circle"></i>
                </button>
            </td>
        </tr>
    </tfoot>
</table>
<?php
$script     = "$('body').on('click', '#add-discount-value-row',
                                    function(event, jqXHR, settings)
                                    {
                                        var rowCount         = $('#discount-value-table tbody tr').length;
                                        var newTr            = $('.discount-value-row-dummy').clone();
                                        $(newTr).removeClass('discount-value-row-dummy').addClass('discount-value-row-' + rowCount);
                                        var newId            = 'discount-value-row-' + (rowCount);
                                        $(newTr).attr('id', newId);
                                        $(newTr).find('.dummy-discount').attr('name', 'ProductDiscount[##rowCount##][group_id]').removeClass('dummy-discount');
                                        var trContent = $(newTr).html();
                                        //http://www.w3schools.com/jsref/jsref_replace.asp
                                        trContentModified = trContent.replace(/##rowCount##/g, rowCount);
                                        $(newTr).html(trContentModified);
                                        $(newTr).appendTo('#discount-value-table tbody');
                                        $(newTr).show();
                                        $(newTr).find('.datefield').datetimepicker({autoclose:true, format:'yyyy-mm-dd hh:ii:ss'});
                                    }
                                )";
$this->registerJs($script);