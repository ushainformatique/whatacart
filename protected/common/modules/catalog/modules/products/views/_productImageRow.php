<?php
use usni\UsniAdaptor;
use usni\library\components\UiHtml;
use usni\library\utils\StringUtil;
?>
<tr class="productimage-value-row" id="productimage-value-row-<?php echo $index;?>">
    <?php echo UiHtml::hiddenInput("ProductImage[$index][id]", $productImageId);?>
    <td class="text-left">
        <input type="text" name="ProductImage[<?php echo $index;?>][caption]" value="<?php echo $caption;?>" placeholder="<?php echo UsniAdaptor::t('products', 'Caption');?>" class="form-control">
    </td>
    <td class="text-right">
        <?php
            if($image == null)
            {
                echo UiHtml::fileInput("ProductImage[$index][uploadInstance]", $image, ['placeholder' => UsniAdaptor::t('application', 'Image'), 'class' => 'form-control']);
            }
            else
            {
                $file = StringUtil::replaceBackSlashByForwardSlash(UsniAdaptor::app()->getAssetManager()->thumbUploadPath . DS . '150_150_' .$image);
                if(file_exists($file))
                {
                    echo UiHtml::img(UsniAdaptor::app()->getAssetManager()->getThumbnailUploadUrl() . DS . '150_150_' .$image);
                }
                echo UiHtml::fileInput("ProductImage[$index][uploadInstance]", null, ['placeholder' => UsniAdaptor::t('products', 'Image'), 'class' => 'form-control']);
            }
            
        ?>
    </td>
    <td class="text-right">
        <button type="button" onclick="$(this).tooltip('destroy');
                    $(this).closest('.productimage-value-row').remove();$(this).removeProductImage('<?php echo $deleteUrl;?>', '<?php echo $productImageId;?>');" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="<?php echo UsniAdaptor::t('products', 'Remove');?>">
            <i class="fa fa-minus-circle"></i>
        </button>
    </td>
</tr>