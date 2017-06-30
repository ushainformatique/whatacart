<?php
use usni\UsniAdaptor;
?>
<div class="modal fade in" id="sendNewsletterModal" tabindex="-1" role="dialog" aria-labelledby="screenOptionsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="modalclose">&times;</button>
                <h4 class="modal-title" id="screenOptionsLabel"><?php echo $title; ?></h4>
            </div>
            <div id="newslettersuccessmessage" style="display: none" class="alert alert-success">
                <?php echo UsniAdaptor::t('newsletter', 'Thank you for subscribing to our newsletter'); ?>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php echo $content; ?>
                </div>
            </div>
        </div>
    </div>
</div>