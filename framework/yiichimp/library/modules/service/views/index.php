<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */

use usni\UsniAdaptor;
use usni\library\modules\service\widgets\RunServices;

$title                          = UsniAdaptor::t('application', 'Manage Services');
$this->params['breadcrumbs'][]  = $title;
$this->title                    = $title;
?>
<div class="alert alert-info">
    <?php echo UsniAdaptor::t('service', 'The list of services provided below are at the system level so before running them, make sure they are not going to effect your current set up.'); ?>
</div>
<div class='panel panel-default'>
    <div class="panel-heading">
        <h6 class="panel-title"><?php echo $title; ?></h6>
    </div>
    <div class="panel-body">
        <table class="table">
            <tbody>
                <?php
                echo RunServices::widget();
                ?>
            </tbody>
        </table>
    </div>
</div>
