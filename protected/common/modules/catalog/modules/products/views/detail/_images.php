<?php
use usni\UsniAdaptor;
use usni\library\utils\StringUtil;
use usni\library\utils\Html;
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
        foreach($productImages as $index => $image)
        {
            ?>
        <tr>
            <td class="text-left">
                <?php echo $image['caption']; ?>
            </td>
            <td class="text-right">
                <?php
                $file = StringUtil::replaceBackSlashByForwardSlash(UsniAdaptor::app()->getAssetManager()->thumbUploadPath . DS . '150_150_' . $image['image']);
                if (file_exists($file))
                {
                    echo Html::img(UsniAdaptor::app()->getAssetManager()->getThumbnailUploadUrl() . DS . '150_150_' . $image['image']);
                }
                ?>
            </td>
        </tr>   
        <?php
        }
        ?>
    </tbody>
</table>