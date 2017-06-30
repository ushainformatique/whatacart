<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
use usni\library\utils\DateTimeUtil;
use usni\library\utils\FileUploadUtil;

$htmlOptions = ['cssClass' => 'media-object', 'thumbWidth' => 64, 'thumbHeight' => 64];
if($model['profile_image'] == null)
{
    //Read from ImageBehavior
    $profileImage = $this->getNoProfileImage($htmlOptions);
}
else
{
    $profileImage = FileUploadUtil::getThumbnailImage($model, 'profile_image', $htmlOptions);
}
?>
<div class="media">
    <div class="media-left media-middle">
        <a href="#">
          <?php echo $profileImage;?>
        </a>
    </div>
    <div class="media-body">
        <h5 class="media-heading">
            <?php echo $model['name']; ?><span class="pull-right review-date" style="text-align: right"><?php echo DateTimeUtil::getFormattedDateTime($model['created_datetime']); ?></span>
        </h5>
        <?php echo $model['review']; ?>
    </div>
</div>