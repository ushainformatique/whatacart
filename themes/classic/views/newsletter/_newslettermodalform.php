<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */

use usni\UsniAdaptor;
?>
<div class="modal fade in" id="<?php echo $modalId;?>" tabindex="-1" role="dialog" aria-labelledby="screenOptionsLabel" aria-hidden="true">
    <div class="modal-dialog <?php echo $modalSize;?>">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="modalclose">&times;</button>
                <h4 class="modal-title" id="screenOptionsLabel"><?php echo $title;?></h4>
            </div>
            <div id="newsletterform">
            <?php echo $begin;?>
            <div class="modal-body with-padding">
                <!--div class="row"-->
                    <?php echo $elements;?>
                <!--/div-->
            </div>
            <div class="modal-footer">
                <?php echo $buttons;?>
            </div>
            <?php echo $end;?>
            </div>
            <br/>
            <div id="newslettersuccessmessage" style="display: none" class="alert alert-success">
                <?php echo UsniAdaptor::t('newsletter', 'Thank you for subscribing to our newsletter'); ?>
            </div>
        </div>
    </div>
</div>