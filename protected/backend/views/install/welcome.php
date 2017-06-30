<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use usni\library\utils\Html;
use usni\UsniAdaptor;
?>
<div class="page-header">
    <div class="page-title">
        <h3><?php echo UsniAdaptor::t('application', 'WhatACart Installation');?></h3>
    </div>
</div>
<div class='panel panel-default panel-install'>
    <div class="panel-heading">
        <h6 class="panel-title">
            <?php echo UsniAdaptor::t('application', 'Welcome to WhatACart'); ?>
        </h6>
    </div>
    <div class='panel-body'>
        <?php echo UsniAdaptor::t('application', 'WhatACart is an open source ecommerce system which could be used to develop an online store in multiple languages. '
            . 'A sample store is provided along with the installed application.'); ?>
        <div class='form-actions text-right'>
                    <?php echo Html::a(UsniAdaptor::t('application', 'Continue'),
                                                UsniAdaptor::createUrl('/install/default/check-system'),
                                                array('class' => 'btn btn-success'));
                    ?>
        </div>
    </div>
</div>