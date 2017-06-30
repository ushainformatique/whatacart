<?php
use usni\UsniAdaptor;
use backend\widgets\LanguageSelector;
use backend\widgets\StoreSelector;
use frontend\widgets\CurrencySelector;

/* @var $this \frontend\web\View */
?>
<nav id="top">
    <div class="container">
        <div class="hidden-xs hidden-sm hidden-md pull-left" id="local-options">
            <ul class="list-inline">
                <?php
                echo LanguageSelector::widget([
                                                'selectedLanguage' => UsniAdaptor::app()->languageManager->selectedLanguage,
                                                'translatedLanguages' => UsniAdaptor::app()->languageManager->translatedLanguages,
                                                'languages'        => UsniAdaptor::app()->languageManager->languages,
                                                'actionUrl'        => '/customer/site/change-language',
                                                'headerLinkOptions' => ['data-toggle' => 'dropdown', 'class' => 'dropdown-toggle'],
                                                'view'             => $this
                                               ]);
                echo StoreSelector::widget([
                                                        'selectedStore' => UsniAdaptor::app()->storeManager->selectedStore,
                                                        'stores'        => UsniAdaptor::app()->storeManager->getAllowed(),
                                                        'headerLinkOptions' => ['data-toggle' => 'dropdown', 'class' => 'dropdown-toggle'],
                                                        'actionUrl'        => '/customer/site/set-store',
                                                        'view'             => $this
                                                    ]);
                echo CurrencySelector::widget([
                                                        'selectedCurrency' => UsniAdaptor::app()->currencyManager->selectedCurrency,
                                                        'currencies'       => UsniAdaptor::app()->currencyManager->currencyCodes,
                                                        'actionUrl'        => '/customer/site/set-currency',
                                                        'view'             => $this
                                                    ]);
                ?>
            </ul>
        </div>
        <?php
        echo $this->render("//common/_topnav");
        ?>
    </div>
</nav>
<header>
    <div class="container header-row">
        <div class="row">
            <div class="col-sm-4">
                <div id="logo">
                    <?php echo $this->render("//common/_logo");?>
                </div>
            </div>
            <div class="col-sm-5">
                <?php echo $this->render("//common/_navSearch");?>
            </div>
            <div class="col-sm-3">
                <?php echo $this->render("//cart/_minicart");?>
            </div>
        </div>
    </div>
</header>