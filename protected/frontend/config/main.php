<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use yii\helpers\ArrayHelper;

$config  = ArrayHelper::merge(
                    require(USNI_PATH . '/library/config/common.php'), array(
                                    'id'                    => $frontAppId,
                                    'displayName'           => $frontDisplayName,
                                    'poweredByName'         => $poweredByName,
                                    'poweredByUrl'          => $poweredByUrl,
                                    'basePath'              => dirname(__DIR__),
                                    'controllerNamespace'   => 'frontend\controllers',
                                    'defaultRoute'          => 'site/default/index',
                                    'components'        => array(
                                        'user'       => [
                                                            'class'    => 'frontend\components\WebUser',
                                                            'loginUrl' => ['/customer/site/login'],
                                                            'idParam'  => 'front__id',
                                                            'identityClass' => 'customer\models\Customer',
                                                            'identityCookie' => [
                                                                                'name' => '_frontendCustomer', // unique for frontend
                                                                             ]
                                                        ],
                                        'urlManager' => [
                                                            'enablePrettyUrl' => true,
                                                            'showScriptName'  => false,
                                                            'rules'           => [
                                                                                    '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>'
                                                                                 ],
                                                        ],
                                        'request'           => [
                                                                    'class'     => 'usni\library\components\UiRequest',
                                                               ],
                                        'assetManager'      => [
                                                                    'class'     => 'frontend\components\AssetManager',
                                                                    'bundles' => [
                                                                                    'yii\bootstrap\BootstrapAsset' => [
                                                                                        'css' => [],
                                                                                    ],
                                                                                    'usni\library\extensions\select2\Select2Asset' => [
                                                                                        'depends' => ['usni\library\assets\UiFrontAssetBundle'],
                                                                                    ]
                                                                                ]
                                                                ],
                                        'flashManager'      => ['class' => 'frontend\components\FrontFlashManager'],
                                        'languageManager'   => ['class' => 'usni\library\components\LanguageManager',
                                                                'applicationLanguageCookieName' => 'whatacartFrontLanguage',
                                                                'contentLanguageCookieName' => 'whatacartFrontContentLanguage'],
                                        'moduleManager'      => ['class' => 'usni\library\components\FrontModuleManager'],
                                        'currencyManager'    => ['class' => 'common\components\CurrencyManager',
                                                                 'applicationCurrencyCookieName' => 'whatacartFrontCurrency'],
                                        'storeManager'       => ['class' => 'common\managers\StoreManager',
                                                                 'applicationStoreCookieName' => 'whatacartFrontStore'],
                                        'view'               => ['class' => 'usni\library\components\View'],
                                        'maintenanceManager' => ['class' => 'usni\library\components\UiMaintenanceManager', 
                                                                 'url' => 'site/default/maintenance'],
                                        'viewHelper'         => ['class' => 'frontend\components\FrontViewHelper'],
                                        'guest'              => ['class' => 'frontend\components\Guest'],
                                        'customer'           => ['class' => 'frontend\components\Customer'],
                                        'log' => [
                                            'traceLevel' => YII_DEBUG ? 3 : 0,
                                            'targets' => [
                                                    [
                                                        'class' => 'yii\log\FileTarget',
                                                        'logFile' => '@runtime/logs/paypal_standard.log',
                                                        'levels' => ['error', 'warning', 'info'],
                                                        'logVars' => ['_GET', '_POST', '_SESSION'],
                                                        'categories' => ['paypal_standard'],
                                                    ]
                                                ]
                                            ],
                                        'errorHandler'      => ['errorAction' => 'site/default/error'],
                                        'session'           => [
                                                                    'name' => 'PHPFRONTSESSID'
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