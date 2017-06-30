<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
use yii\helpers\ArrayHelper;

$config  = ArrayHelper::merge(
                    require(USNI_PATH . '/library/config/common.php'), array(
                                    'id'                    => 'whatacart-console',
                                    'basePath'              => dirname(__DIR__),
                                    'controllerNamespace'   => 'console\controllers',
                                    //'controllerMap'         => ['message' => 'console\controllers\MessageController'],
                                    'components'        => [
                                                            'user'          => ['loginUrl' => ['/users/default/login'], 'class' => 'usni\library\console\ConsoleUser'],
                                                            'languageManager'   => ['class' => 'usni\library\components\LanguageManager'],
                                                            'currencyManager'   => ['class' => 'common\modules\localization\modules\currency\components\CurrencyManager'],
                                                            'storeManager'      => ['class' => 'common\modules\stores\components\StoreManager']
                                                            ]                                    
                    )
);
$instanceConfigFile = APPLICATION_PATH . '/protected/common/config/instanceConfig.php'; 
if(file_exists($instanceConfigFile))
{
    $config = ArrayHelper::merge($config, require($instanceConfigFile));
}
return $config;