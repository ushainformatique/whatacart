<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use yii\widgets\Menu;
use usni\UsniAdaptor;

if(UsniAdaptor::app()->isInstalled())
{
    //Dashboard
    $items[]    = require_once UsniAdaptor::app()->getModule('home')->basePath . '/config/menu.php';
    //Catalog
    $items[]    = require_once UsniAdaptor::app()->getModule('catalog')->basePath . '/config/menu.php';
    //Cms
    $items[]    = require_once UsniAdaptor::app()->getModule('cms')->basePath . '/config/menu.php';
    //Extensions
    $items[]    = require_once UsniAdaptor::app()->getModule('extension')->basePath . '/config/menu.php';
    //Marketing
    $items[]    = require_once UsniAdaptor::app()->getModule('marketing')->basePath . '/config/menu.php';
    //Stores
    $items[]    = require_once UsniAdaptor::app()->getModule('stores')->basePath . '/config/menu.php';
    //System
    $items[]    = require_once UsniAdaptor::getAlias('@backend') . '/config/menu.php';
    //Sales Menu
    $items[]    = require_once UsniAdaptor::getAlias('@backend') . '/config/salesmenu.php';
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