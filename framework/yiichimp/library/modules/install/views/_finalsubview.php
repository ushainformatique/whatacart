<?php
use usni\fontawesome\FA;
use usni\library\utils\Html;
use usni\UsniAdaptor;
?>
<div class='panel panel-default panel-install'>
    <div class="panel-heading">
        <h6 class="panel-title">
            <?php echo UsniAdaptor::t('install', 'Installation Output'); ?>
        </h6>
    </div>
    <div class='panel-body'>
        <div id="progress-container">
            <div class="progress progress-striped active">
                <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                    <span class="install-progress">0%</span>
                </div>
            </div>
            <div id="progress-messages">

            </div>
        </div>
        <div id="final-overview" class="hide">
            <div class="alert alert-success">
                <?php echo UsniAdaptor::t('install', 'Well done! You have installed the application successfully.'); ?>
            </div>
            <div class="form-actions" style="margin-top: 10px">
                <?php
                $adminUrl   = UsniAdaptor::createUrl('/users/default/login');
                $refPos     = strpos($adminUrl, '/backend');
                $frontUrl   = substr($adminUrl, 0, $refPos + 1);
                $label = FA::icon('lock') . "\n" . UsniAdaptor::t('application', 'Admin Panel');
                echo Html::a($label, UsniAdaptor::createUrl('/users/default/login'), array('class' => 'btn btn-primary')) . ' ';
                $label = FA::icon('eye') . "\n" . UsniAdaptor::t('application', 'Site');
                echo Html::a($label, $frontUrl, array('class' => 'btn btn-warning'));
                ?>
            </div>
        </div>
        <div id="install-errors" class="hide">
            <div class="alert alert-danger" id="error-messages">

            </div>
            <div class="form-actions" style="margin-top: 10px">
                <?php
                $label = FA::icon('lock') . "\n" . UsniAdaptor::t('install', 'Restart');
                echo Html::a($label, UsniAdaptor::createUrl('/install/default/index'), array('class' => 'btn btn-default'));
                ?>
            </div>
        </div>
    </div>
</div>