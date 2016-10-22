<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\UsniAdaptor;
?>
<div class='col-md-2 text-right'>
    <label class="control-label" for="<?php echo $id;?>"> 
        <?php echo UsniAdaptor::t('application', 'Sort By');?>
    </label>
</div>
<div class='col-md-3 text-right'>
    <?php echo $content;?>
</div>