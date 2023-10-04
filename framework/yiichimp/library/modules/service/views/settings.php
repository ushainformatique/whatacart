<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
use usni\UsniAdaptor;
?>
<div class='panel panel-default'>
    <div class="panel-heading">
        <div class="panel-title">
            <?php echo UsniAdaptor::t('service', 'System Configuration'); ?>
        </div>
    </div>
    <?php
    echo UsniAdaptor::app()->controller->renderPartial('@usni/themes/bootstrap/views/install/_systemconf', 
                                                       array('requirements' => $requirements,
                                                             'summary'      => $summary));
    ?>
</div>

