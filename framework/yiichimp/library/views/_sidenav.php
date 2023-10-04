<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
use yii\widgets\Menu;
use usni\UsniAdaptor;

if(UsniAdaptor::app()->isInstalled())
{
    //Dashboard
    $items[]    = require_once UsniAdaptor::app()->getModule('home')->basePath . '/config/menu.php';
    //System
    $items[]    = require_once UsniAdaptor::getAlias('@usni/library') . '/config/menu.php';
    ?>
    <!--Sidebar Begins-->
    <div class="sidebar">
        <div class="sidebar-content">
            <?php
                if(!UsniAdaptor::app()->user->isGuest)
                {
                    echo Menu::widget([
                        'items'         => $items,
                        'options'       => ['class' => 'navigation'],
                        'encodeLabels'  => false,
                        'activateParents' => true
                    ]);
                }
            ?>
        </div>
    </div>
<!--Sidebar Ends-->
<?php
}

