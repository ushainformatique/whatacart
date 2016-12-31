<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use yii\helpers\ArrayHelper;

$config  = ArrayHelper::merge(
                    require(USNI_PATH . '/library/config/common.php'), array(
                                    'id'                    => 'tgh-console',
                                    'basePath'              => dirname(__DIR__),
                                    'controllerNamespace'   => 'console\controllers',
                                    'components'        => array(
                                        'user'          => ['loginUrl' => ['/users/default/login'], 'class' => 'usni\library\components\UiConsoleUser'],
                                        'languageManager'   => ['class' => 'console\components\LanguageManager',
                                                                'contentLanguageCookieName' => 'whatacartConsoleContentLanguage',
                                                                'applicationLanguageCookieName' => 'whatacartConsoleLanguage'],
                                        'currencyManager'    => ['class' => 'console\components\CurrencyManager',
                                                                 'applicationCurrencyCookieName' => 'consoleCurrency'],
                                        'storeManager'       => ['class' => 'common\managers\StoreManager',
                                                                 'applicationStoreCookieName' => 'consoleStore'],
                                        'moduleManager'      => ['class' => 'usni\library\components\UiModuleManager']
                                    )
                    )
);
$instanceConfigFile = APPLICATION_PATH . '/protected/common/config/instanceConfig.php'; 
if(file_exists($instanceConfigFile))
{
    $config = ArrayHelper::merge($config, require($instanceConfigFile));
}
return $config;