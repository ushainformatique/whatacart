<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
use usni\UsniAdaptor;

$title                          = UsniAdaptor::t('service', 'System Configuration');
$this->params['breadcrumbs']    = [
                                    [
                                        'label' => UsniAdaptor::t('application', 'Manage Services'), 
                                        'url' => UsniAdaptor::createUrl('service/default/index')
                                    ],
                                    [ 
                                        'label' => $title
                                    ]
                                   ];
$this->title                    = $title;
/* @var $this \usni\library\web\AdminView */
?>
<div class='panel panel-default'>
    <div class="panel-heading">
        <h6 class="panel-title">
            <?php echo $title; ?>
        </h6>
    </div>
    <div class='panel-body'>
    <?php
    echo $this->render('/_systemconf', array('requirements' => $requirements,
                                             'summary'      => $summary));
    ?>
    </div>
</div>