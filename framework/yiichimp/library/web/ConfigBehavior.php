<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\web;

use usni\library\utils\CacheUtil;
/**
 * ConfigBehavior implements the functionality related to app config on the web end
 *
 * @package usni\library\web
 */
class ConfigBehavior extends \yii\base\Behavior
{
    /**
     * Get value for the configuration.
     * @param string $module
     * @param string $key
     * @return string
     */
    public function getConfigValue($module, $key)
    {
        $configData = CacheUtil::get('appconfig');
        if($configData === false || !isset($configData[$module][$key]))
        {
            return null;
        }
        else
        {
            return $configData[$module][$key];
        }
    }
}