<?php
use usni\UsniAdaptor;
use usni\library\utils\Html;
use usni\library\utils\StringUtil;

/* @var $formDTO \products\dto\FormDTO */
/* @var $form \usni\library\bootstrap\ActiveForm */

$productImages    = $formDTO->images;
$errors           = $formDTO->model->getErrors('images');
if(!empty($errors))
{
?>
<div class="alert alert-danger">
    <?php echo implode('<br/>', $errors);?>
</div>
<?php
}
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
        <?php
        if(!empty($productImages))
        {
            foreach($productImages as $index => $productImage)
            {
                ?>
                <tr class="productimage-value-row" id="productimage-value-row-<?php echo $index;?>">
                    <?php echo Html::activeHiddenInput($productImage, "[$index]id");?>
                    <td class="text-left">
                        <?= $form->field($productImage, "[$index]caption")->textInput(['placeholder' => UsniAdaptor::t('products', 'Caption')])->label(false);?>
                    </td>
                    <td class="text-right">
                        <?php
                        if($productImage->image != null)
                        {
                            $file = StringUtil::replaceBackSlashByForwardSlash(UsniAdaptor::app()->assetManager->thumbUploadPath . DS . '150_150_' . $productImage->image);
                            if(file_exists($file))
                            {
                                echo Html::img(UsniAdaptor::app()->assetManager->getThumbnailUploadUrl() . DS . '150_150_' . $productImage->image);
                            }
                        }
                        ?>
                        <?= $form->field($productImage, "[$index]uploadInstance")->fileInput()->label(false);?>
                    </td>
                    <?php $deleteUrl = UsniAdaptor::createUrl('catalog/products/product-image/delete');?>
                    <td class="text-right">
                        <button type="button" onclick="$(this).tooltip('destroy');
                                    $(this).closest('.productimage-value-row').remove();$(this).removeProductImage('<?php echo $deleteUrl;?>', '<?php echo $productImage->id;?>');" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="<?php echo UsniAdaptor::t('products', 'Remove');?>">
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
            <td class="text-right" colspan="3">
                <button type="button" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="<?php echo UsniAdaptor::t('products', 'Add Image');?>" id="add-productimage-value-row">
                    <i class="fa fa-plus-circle"></i>
                </button>
            </td>
        </tr>
    </tfoot>
</table>
<?php
$script     = " $('body').on('click', '#add-productimage-value-row',
                                    function(event, jqXHR, settings)
                                    {
                                        var rowCount         = $('#productimage-value-table > tbody tr').length;
                                        if(rowCount <= 4)
                                        {
                                            var newTr            = $('.productimage-value-row-dummy').clone();
                                            $(newTr).removeClass('productimage-value-row-dummy').addClass('productimage-value-row');
                                            var newId            = 'productimage-value-row-' + (rowCount);
                                            $(newTr).attr('id', newId);
                                            var htmlContent = $(newTr).html();
                                            var content = htmlContent.replace(/##dummyindex##/g, rowCount);
                                            $(newTr).html(content);
                                            $(newTr).appendTo('#productimage-value-table tbody');
                                            $(newTr).show();
                                        }
                                    }
                                );
                                ";
$this->registerJs($script);
$script = "$.fn.extend({
                    removeProductImage:function(url, productImageId)
                    {
                        $.ajax({
                                url: url,
                                type: 'get',
                                data: 'id=' + productImageId,
                                dataType: 'json',
                                success: function(json) {	
                                }
                            });
                    }
                    })";
$this->registerJs($script);