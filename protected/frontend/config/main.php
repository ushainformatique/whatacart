<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use yii\helpers\ArrayHelper;

$config  = array(
                    'id'                    => 'whatacart',
                    'basePath'              => dirname(__DIR__),
                    'controllerNamespace'   => 'frontend\controllers',
                    'defaultRoute'          => 'site/default/index',
                    'components'        => array(
                        'user'       => [
                                            'loginUrl' => ['/customer/site/login'],
                                            'idParam'  => 'front__id',
                                            'identityClass' => 'customer\models\Customer',
                                            'identityCookie' => [
                                                                'name' => '_frontendCustomer', // unique for frontend
                                                             ],
                                            'as user'      => ['class' => 'frontend\web\CustomerBehavior']
                                        ],
                        'urlManager' => [
                                            'enablePrettyUrl' => true,
                                            'showScriptName'  => false,
                                            'rules'           => [
                                                                    '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>'
                                                                 ],
                                        ],
                        'assetManager'      => [
                                                    'bundles' => [
                                                                    'yii\bootstrap\BootstrapAsset' => [
                                                                        'css' => [],
                                                                    ],
                                                                ]
                                                ],
                        'flashManager'      => ['class' => 'frontend\components\FrontFlashManager'],
                        'languageManager'   => ['class' => 'usni\library\components\LanguageManager'],
                        'moduleManager'      => ['class' => 'usni\library\components\ModuleManager'],
                        'currencyManager'    => ['class' => 'common\modules\localization\modules\currency\components\CurrencyManager'],
                        'storeManager'       => ['class' => 'common\modules\stores\components\StoreManager'],
                        'view'               => ['class' => 'frontend\web\View'],
                        'maintenanceManager' => ['class' => 'usni\library\components\MaintenanceManager', 
                                                 'url' => 'site/default/maintenance'],
                        'guest'              => ['class' => 'frontend\components\Guest'],
                        'customer'           => ['class' => 'frontend\components\Customer'],
                        'errorHandler'      => ['errorAction' => 'site/default/error'],
                        'session'           => [
                                                    'name' => 'PHPFRONTSESSID'
                                                ],
                        'cookieManager'     => [
                                                'class' => 'common\web\CookieManager',
                                                'contentLanguageCookieName' => 'whatacartFrontContentLanguage',
                                                'applicationStoreCookieName' => 'whatacartFrontStore',
                                                'applicationCurrencyCookieName' => 'whatacartFrontCurrency'
                                            ]
                    ),
                    'as beforeAction'   => ['class' => 'frontend\web\BeforeActionBehavior']
                );
$instanceConfigFile = APPLICATION_PATH . '/protected/common/config/instanceConfig.php'; 
if(file_exists($instanceConfigFile))
{
    $config = ArrayHelper::merge($config, require($instanceConfigFile));
}
return $config;