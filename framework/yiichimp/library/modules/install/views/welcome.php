<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
use usni\library\utils\Html;
use usni\UsniAdaptor;
?>
<div class="page-header">
    <div class="page-title">
        <h3><?php echo $this->title;?></h3>
    </div>
</div>
<div class='panel panel-default panel-install'>
    <div class="panel-heading">
        <h6 class="panel-title">
            <?php echo UsniAdaptor::t('application', 'Welcome to Application'); ?>
        </h6>
    </div>
    <div class='panel-body'>
        <?php echo UsniAdaptor::t('application', 'Application Description.'); ?>
        <div class='form-actions text-right'>
                    <?php echo Html::a(UsniAdaptor::t('application', 'Continue'),
                                                UsniAdaptor::createUrl('/install/default/check-system'),
                                                array('class' => 'btn btn-success'));
                    ?>
        </div>
    </div>
</div>