<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
defined('APPLICATION_PATH') or define('APPLICATION_PATH', dirname(__FILE__));
$instanceDir = APPLICATION_PATH . '/protected/common/config';
if(file_exists($instanceDir . '/instance.php'))
{
    require($instanceDir . '/instance.php');
}
else
{
    if(!file_exists($instanceDir . '/instance.install.php'))
    {
        copy($instanceDir . '/instance.install.sample.php', $instanceDir . '/instance.install.php');
    }
    require($instanceDir . '/instance.install.php');
}
defined('YII_ENV') or define('YII_ENV', $environment);
defined('YII_DEBUG') or define('YII_DEBUG', $debug);
defined('VENDOR_PATH') or define('VENDOR_PATH', $vendorPath . DIRECTORY_SEPARATOR . 'vendor');
defined('USNI_PATH') or define('USNI_PATH', VENDOR_PATH . '/ushainformatique/yiichimp');

require(VENDOR_PATH . '/autoload.php');
require(VENDOR_PATH . '/yiisoft/yii2/Yii.php');

require(USNI_PATH . '/library/config/bootstrap.php');
require(APPLICATION_PATH . '/protected/common/config/bootstrap.php');
require(APPLICATION_PATH . '/protected/frontend/config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require(APPLICATION_PATH . '/protected/common/config/main.php'),
    require(APPLICATION_PATH . '/protected/common/config/main-local.php'),
    require(APPLICATION_PATH . '/protected/frontend/config/main.php'),
    require(APPLICATION_PATH . '/protected/frontend/config/main-local.php')
);
if(file_exists(APPLICATION_PATH . '/protected/common/config/main-extended.php'))
{
    $config = yii\helpers\ArrayHelper::merge($config, require(APPLICATION_PATH . '/protected/common/config/main-extended.php'));
}
if(file_exists(APPLICATION_PATH . '/protected/frontend/config/main-extended.php'))
{
    $config = yii\helpers\ArrayHelper::merge($config, require(APPLICATION_PATH . '/protected/frontend/config/main-extended.php'));
}
$application = new frontend\web\Application($config);
$application->run();