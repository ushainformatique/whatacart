<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
use usni\UsniAdaptor;
use usni\library\utils\Html;

/* @var $this \usni\library\web\AdminView */
?>
<div class="page-header">
    <div class="page-title">
        <h3><?php echo $this->title;?></h3>
    </div>
</div>
<div class='panel panel-default panel-install'>
    <div class="panel-heading">
        <h6 class="panel-title">
            <?php echo UsniAdaptor::t('install', 'Pre-Installation Check'); ?>
        </h6>
    </div>
    <div class='panel-body'>
    <?php
    echo $this->render('/_systemconf', array('requirements' => $requirements,
                                             'summary'      => $summary));
    ?>
        <br/>
            <div class='form-actions text-right'>
                <?php
                if ($summary['errors'] == 0)
                {
                    echo Html::a(UsniAdaptor::t('application', 'Continue'), UsniAdaptor::createUrl('/install/default/settings'), array('class' => 'btn btn-success'));
                }
                else
                {
                    echo Html::a(UsniAdaptor::t('application', 'Recheck'), UsniAdaptor::createUrl('/install/default/check-system'), array('class' => 'btn btn-danger'));
                }
                ?>
            </div>
    </div>
</div>