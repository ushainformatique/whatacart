<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */

use usni\fontawesome\FA;
use usni\UsniAdaptor;
use usni\library\utils\Html;
use yii\helpers\Url;
use usni\library\modules\settings\widgets\TopNavSettingsMenu;
use usni\library\modules\users\widgets\TopNavUserMenu;
?>
<!--Navbar Begins-->
<div class="navbar navbar-inverse" role="navigation">
    <?php
    echo $this->render('@usni/library/views/_navbarHeader', ['title' => UsniAdaptor::app()->name . ' ' . UsniAdaptor::t('application', 'CPanel')]);
    if(!UsniAdaptor::app()->user->isGuest &&  UsniAdaptor::app()->isRebuildInProgress() === false)
    {
    ?>
            <ul class="nav navbar-nav navbar-right" id="navbar-icons">
                <li>
                        <?php
                            $label = FA::icon('trash') . "\n" . UsniAdaptor::t('application', 'Clear Cache');
                            echo Html::a($label, Url::current(['clearCache' => 'true']));
                        ?>
                </li>
                <?php
                    echo TopNavSettingsMenu::widget();
                    echo TopNavUserMenu::widget();
                ?>
            </ul>
        <!--/div-->
    <?php
    }
    ?>
</div>
<!--Navbar Ends-->