<?php
use usni\UsniAdaptor;
use usni\library\components\UiHtml;
use usni\library\utils\StringUtil;
?>
<tr>
    <td class="text-left">
        <?php echo $caption; ?>
    </td>
    <td class="text-right">
        <?php
        $file = StringUtil::replaceBackSlashByForwardSlash(UsniAdaptor::app()->getAssetManager()->thumbUploadPath . DS . '150_150_' . $image);
        if (file_exists($file))
        {
            echo UiHtml::img(UsniAdaptor::app()->getAssetManager()->getThumbnailUploadUrl() . DS . '150_150_' . $image);
        }
        ?>
    </td>
</tr>