<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use yii\helpers\ArrayHelper;

$config  = ArrayHelper::merge(
                    require(USNI_PATH . '/library/config/common.php'), array(
                                    'id'                => $backendAppId,
                                    'displayName'       => $backendDisplayName,
                                    'poweredByName'     => $poweredByName,
                                    'poweredByUrl'      => $poweredByUrl,
                                    'frontTheme'        => $frontTheme,
                                    'basePath'          => dirname(__DIR__),
                                    'controllerNamespace' => 'backend\controllers',
                                    'defaultRoute'        => 'home/default/index', //Example 'home/default/index'
                                    'components'        => array(
                                        'user'       => ['loginUrl' => ['/users/default/login'],
                                                         'identityCookie' => [
                                                                                'name' => '_backendUser', // unique for backend
                                                                             ]
                                                        ],
                                        'urlManager' => [
                                                            'enablePrettyUrl' => true,
                                                            'showScriptName'  => true,
                                                        ],
                                        'viewHelper'    => ['class'         => 'usni\library\components\UiAdminViewHelper',
                                                            'topNavView'    => 'backend\views\AdminTopNavView',
                                                            'columnView'    => 'backend\views\AdminTwoColumnView',
                                                            'menuView'      => 'backend\views\SidebarMenuView'
                                                           ],
                                        'request'           => [
                                                                    'class'     => 'usni\library\components\UiRequest',
                                                               ],
                                        'view'              => [
                                                                    'class' => 'usni\library\components\View',
                                                                    'theme' => [
                                                                                'basePath' => '@webroot/themes/bootstrap',
                                                                                'baseUrl' => '@web/themes/bootstrap'
                                                                           ]
                                                                ],
                                        'errorHandler'      => ['errorAction' => 'users/default/error'],
                                        'languageManager'   => ['class' => 'usni\library\components\LanguageManager',
                                                                'contentLanguageCookieName' => 'whatacartAdminContentLanguage',
                                                                'applicationLanguageCookieName' => 'whatacartAdminLanguage'],
                                        'currencyManager'   => ['class' => 'common\components\CurrencyManager',
                                                                 'applicationCurrencyCookieName' => 'whatacartAdminCurrency'],
                                        'moduleManager'     => ['class' => 'usni\library\components\AdminModuleManager'],
                                        'storeManager'      => ['class' => 'common\managers\StoreManager',
                                                                 'applicationStoreCookieName' => 'whatacartAdminStore'],
                                        'currencyManager'   => ['class' => 'common\components\CurrencyManager',
                                                                 'applicationCurrencyCookieName' => 'whatacartAdminCurrency'],
                                        'session'           => [
                                                                    'name' => 'PHPBACKSESSID'
                                                                ]
                                    )
                    )
);
$instanceConfigFile = APPLICATION_PATH . '/protected/common/config/instanceConfig.php'; 
if(file_exists($instanceConfigFile))
{
    $config = ArrayHelper::merge($config, require($instanceConfigFile));
}
return $config;
?>