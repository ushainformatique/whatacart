<?php
use usni\UsniAdaptor;

/* @var $formDTO \products\dto\FormDTO */
/* @var $form \usni\library\bootstrap\ActiveForm */

$productSpecials    = $formDTO->specials;
$errors             = $formDTO->model->getErrors('specials');
if(!empty($errors))
{
?>
<div class="alert alert-danger">
    <?php echo implode('<br/>', $errors);?>
</div>
<?php
}
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
        <?php
        if(!empty($productSpecials))
        {
            foreach($productSpecials as $index => $special)
            {
                ?>
                <tr class="special-value-row" id="special-value-row-<?php echo $index;?>">
                    <td class="text-left">
                        <?= $form->field($special, "[$index]group_id")->dropDownList($formDTO->getGroups())->label(false);?>
                    </td>
                    <td class="text-right">
                        <?= $form->field($special, "[$index]priority")->textInput(['placeholder' => UsniAdaptor::t('products', 'Priority')])->label(false);?>
                    </td>
                    <td class="text-left">
                        <?= $form->field($special, "[$index]price")->textInput(['placeholder' => UsniAdaptor::t('products', 'Price')])->label(false);?>
                    </td>
                    <td class="text-right">
                        <?= $form->field($special, "[$index]start_datetime", ['inputOptions' => ['class' => 'form-control datefield']])->textInput(['placeholder' => UsniAdaptor::t('products', 'Start Datetime')])->label(false);?>
                    </td>
                    <td class="text-left">
                        <?= $form->field($special, "[$index]end_datetime", ['inputOptions' => ['class' => 'form-control datefield']])->textInput(['placeholder' => UsniAdaptor::t('products', 'End Datetime')])->label(false);?>
                    </td>
                    <td class="text-right">
                        <button type="button" id="remove-special-value-row" onclick="$(this).tooltip('destroy');
                            $(this).closest('.special-value-row').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="<?php echo UsniAdaptor::t('products', 'Remove');?>" id="remove">
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
            <td colspan="5"></td>
            <td class="text-left">
                <button type="button" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="<?php echo UsniAdaptor::t('products', 'Add Discount');?>" id="add-special-value-row">
                    <i class="fa fa-plus-circle"></i>
                </button>
            </td>
        </tr>
    </tfoot>
</table>
<?php
$script     = "$('body').on('click', '#add-special-value-row',
                                    function(event, jqXHR, settings)
                                    {
                                        var rowCount         = $('#special-value-table tbody tr').length;
                                        var newTr            = $('.special-value-row-dummy').clone();
                                        $(newTr).removeClass('special-value-row-dummy').addClass('special-value-row-' + rowCount);
                                        var newId            = 'special-value-row-' + (rowCount);
                                        $(newTr).attr('id', newId);
                                        $(newTr).find('.dummy-special').attr('name', 'ProductSpecial[##rowCount##][group_id]').removeClass('dummy-special');
                                        var trContent = $(newTr).html();
                                        //http://www.w3schools.com/jsref/jsref_replace.asp
                                        trContentModified = trContent.replace(/##rowCount##/g, rowCount);
                                        $(newTr).html(trContentModified);
                                        $(newTr).appendTo('#special-value-table tbody');
                                        $(newTr).show();
                                        $(newTr).find('.datefield').datetimepicker({autoclose:true, format:'yyyy-mm-dd hh:ii:ss'});
                                    }
                                )";
$this->registerJs($script);