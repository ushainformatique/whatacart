<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */

/* @var $this \usni\library\web\AdminView */
use usni\UsniAdaptor;
use usni\fontawesome\FA;
use usni\library\utils\Html;
use yii\helpers\Url;
use backend\widgets\LanguageSelector;
use backend\widgets\StoreSelector;
use usni\library\modules\settings\widgets\TopNavSettingsMenu;
use usni\library\modules\users\widgets\TopNavUserMenu;

$languageSelection = UsniAdaptor::app()->languageManager->selectedLanguage;
?>
<!--Navbar Begins-->
<div class="navbar navbar-inverse" role="navigation">
    <?php
    echo $this->render('@usni/library/views/_navbarHeader', ['title' => UsniAdaptor::app()->name . ' ' . UsniAdaptor::t('application', 'CPanel')]);
    if(!UsniAdaptor::app()->user->isGuest &&  UsniAdaptor::app()->isRebuildInProgress() === false)
    {
    ?>
            <ul class="nav navbar-nav navbar-right" id="navbar-icons">
                    <?php
                        echo StoreSelector::widget([
                                                        'selectedStore' => UsniAdaptor::app()->storeManager->selectedStore,
                                                        'stores'        => UsniAdaptor::app()->storeManager->getAllowed()
                                                    ]);
                        echo LanguageSelector::widget([
                                                        'selectedLanguage' => $languageSelection,
                                                        'translatedLanguages' => UsniAdaptor::app()->languageManager->translatedLanguages,
                                                        'languages'        => UsniAdaptor::app()->languageManager->languages
                                                    ]); 
                    ?>
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
        <?php
        }
        ?>
</div>
<!--Navbar ends-->