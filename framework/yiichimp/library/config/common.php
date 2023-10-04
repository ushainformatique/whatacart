<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
return array(
    'bootstrap'          => ['log'],
    // application components
    'components'        => [
                                'response' => ['class' => 'usni\library\web\Response'],
                                'user' => [
                                    'class' => 'usni\library\web\User',
                                    // enable cookie-based authentication
                                    'enableAutoLogin' => true,
                                    'identityClass' => 'usni\library\modules\users\models\User',
                                    'as user'      => ['class' => 'usni\library\web\UserBehavior']
                                ],
                                'assetManager' => [
                                    'class'     => 'usni\library\web\AssetManager',
                                    'basePath'  => '@webroot/assets',
                                    'bundles' => [
                                                            'yii\web\JqueryAsset' => [
                                                                'js' => [
                                                                    YII_ENV === 'dev' ? 'jquery.js' : 'jquery.min.js'
                                                                ]
                                                            ],
                                                            'yii\bootstrap\BootstrapAsset' => [
                                                                'css' => [
                                                                    YII_ENV === 'dev' ? 'css/bootstrap.css' : 'css/bootstrap.min.css',
                                                                ]
                                                            ],
                                                            'yii\bootstrap\BootstrapPluginAsset' => [
                                                                'js' => [
                                                                    YII_ENV === 'dev' ? 'js/bootstrap.js' : 'js/bootstrap.min.js',
                                                                ]
                                                            ]
                                                ],
                                ],
                                'i18n'          => [
                                    'class'     => 'usni\library\i18n\I18N'
                                ],
                                'db' => [
                                        'class'             => 'yii\db\Connection',
                                        'emulatePrepare'    => true,
                                        'charset'           => 'utf8'
                                    ],
                                'log' => [
                                            'traceLevel' => YII_DEBUG ? 3 : 0,
                                            'targets' => [
                                                [
                                                    'class' => 'yii\log\FileTarget',
                                                    'logFile' => '@runtime/logs/yii.log',
                                                    'levels' => ['error', 'warning'],
                                                    'logVars' => ['_GET', '_POST'],
                                                    'categories' => ['yii\*'],
                                                    'except'  => ['yii\db\*']
                                                ],
                                                [
                                                    'class' => 'yii\log\FileTarget',
                                                    'logFile' => '@runtime/logs/db.log',
                                                    'levels' => ['error', 'warning'],
                                                    'categories' => ['yii\db\*'],
                                                ],
                                                [
                                                    'class' => 'yii\log\FileTarget',
                                                    'logFile' => '@runtime/logs/app.log',
                                                    'levels' => ['error', 'warning'],
                                                    'logVars' => ['_GET', '_POST'],
                                                    'except'  => ['yii\db\*', 'yii\*'],
                                                ]
                                            ],
                                        ],
                                'globalDataManager'  => ['class' => 'usni\library\db\ApplicationDataManager'],
                                'moduleManager'      => ['class' => 'usni\library\components\ModuleManager'],
                                'authorizationManager' => ['class' => 'usni\library\modules\auth\business\AuthManager'],
                                'configManager'      => ['class' => 'usni\library\business\ConfigManager'],
                                'mailer' => [
                                                'class' => 'yii\symfonymailer\Mailer',
                                                'htmlLayout' => '@usni/library/mail/layouts/html',
                                                'transport' => [
                                                                    'scheme' => 'smtps',
                                                                    'host' => '',
                                                                    'username' => '',
                                                                    'password' => '',
                                                                    'port' => 465,
                                                                    'dsn' => 'native://default',
                                                                ],
                                                'useFileTransport' => true,
                                            ]
                        ],
    'params'            => [],
);