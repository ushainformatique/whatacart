<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
// NOTE: Make sure this file is not accessible when deployed to production
if (!in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']))
{
    die('You are not allowed to access this file.');
}
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');
defined('APPLICATION_PATH') or define('APPLICATION_PATH', dirname(dirname(dirname(__FILE__))));
defined('USNI_PATH') or define('USNI_PATH', APPLICATION_PATH . '/vendor/ushainformatique/yiichimp');
defined('BACKEND_APPLICATION_PATH') or define('BACKEND_APPLICATION_PATH', APPLICATION_PATH . '/backend');

require(APPLICATION_PATH . '/vendor/autoload.php');
require(APPLICATION_PATH . '/vendor/yiisoft/yii2/Yii.php');

require(APPLICATION_PATH . '/common/config/bootstrap.php');
require(BACKEND_APPLICATION_PATH . '/config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require(APPLICATION_PATH . '/common/config/main.php'),
    require(APPLICATION_PATH . '/common/config/main-local.php'),
    require(APPLICATION_PATH . '/backend/config/main.php'),
    require(APPLICATION_PATH . '/backend/config/main-local.php'),
    require(APPLICATION_PATH . '/tests/backend/config.php'),
    require(APPLICATION_PATH . '/tests/backend/functional.php')
);

$application = new backend\web\AdminApplication($config);
$application->run();
