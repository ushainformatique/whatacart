<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
?>
<div class="col-md-2">
    <h2><a href="#"><?php echo $data->name;?></a></h2>
    <p><?php echo FileUploadUtil::getThumbnailImage($data, 'image');?><a class="btn btn-default" role="button" href="#">Add to Cart &raquo;</a></p>
</div>