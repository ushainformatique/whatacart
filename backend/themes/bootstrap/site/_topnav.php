<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
?>
<?php
namespace web\themes\bootstrap\site;

use usni\UsniAdaptor;
use usni\library\modules\settings\utils\SettingsUtil;
use usni\library\modules\users\utils\UserUtil;
use usni\fontawesome\FA;
use usni\library\components\UiHtml;
use yii\helpers\Url;
?>
<!--Navbar Begins-->
<div class="navbar navbar-inverse" role="navigation">
    <div class="navbar-header">
        <a class="navbar-brand" href="<?php echo UsniAdaptor::createUrl('/home/default/dashboard');?>">WhatACart CPanel</a>
        <?php
        if(!UsniAdaptor::app()->user->isGuest && UsniAdaptor::app()->isRebuildInProgress() === false)
        {
        ?>
            <a class="sidebar-toggle">
                <?php echo FA::icon('navicon')->size(FA::SIZE_LARGE);?>
            </a>
        <?php
        }
        ?>
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-icons">
            <span class="sr-only">Toggle navbar</span>
            <?php echo FA::icon('th-large')->size(FA::SIZE_LARGE);?>
        </button>
        <button type="button" class="navbar-toggle offcanvas">
            <span class="sr-only">Toggle navigation</span>
            <?php echo FA::icon('align-justify');?>
        </button>
    </div>
    <?php
    if(!UsniAdaptor::app()->user->isGuest &&  UsniAdaptor::app()->isRebuildInProgress() === false)
    {
    ?>
            <ul class="nav navbar-nav navbar-right" id="navbar-icons">
                    <?php
                        $viewHelper   = UsniAdaptor::app()->getModule('stores')->viewHelper;
                        $storeView    = $viewHelper->getInstance('storeView');
                        echo $storeView->render();
                    ?>
                    <?php
                    $viewHelper     = UsniAdaptor::app()->getModule('language')->viewHelper;
                    $languageView   = $viewHelper->getInstance('languageView');
                    echo $languageView->render();
                    ?>
                    <li>
                        <?php
                            $label = FA::icon('trash') . "\n" . UsniAdaptor::t('application', 'Clear Cache');
                            echo UiHtml::a($label, Url::current(['clearCache' => 'true']));
                        ?>
                    </li>
                    <li class="dropdown">
                        <?php
                            echo SettingsUtil::renderTopnavMenu();
                        ?>
                    </li>
                    <li class="user dropdown">
                        <?php
                            echo UserUtil::renderTopnavMenu();
                        ?>
                    </li>
                </ul>
        <?php
        }
        ?>
</div>
<!--Navbar ends-->