<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\traits;

use usni\library\utils\ArrayUtil;
/**
 * Implement common functions related to store configuration.
 * 
 * @package common\modules\stores\traits
 */
trait StoreConfigTrait
{
    /**
     * Get store configuration attributes by category for store
     * @param string $category
     * @param int $storeId
     * @return array
     */
    public function getConfigurationByCategory($category)
    {
        return ArrayUtil::getValue($this->config, $category, []);
    }
    
    /**
     * Get store configuration attributes by code for store
     * @param string $code
     * @param string $category
     * @return array
     */
    public function getConfigurationByCode($code, $category)
    {
        $configuration = $this->getConfigurationByCategory($category);
        return ArrayUtil::getValue($configuration, $code, null);
    }
    
    /**
     * Get setting value by key
     * @param string $key
     * @return type
     */
    public function getSettingValue($key)
    {
        $configuration = $this->getConfigurationByCode('storesettings', 'storeconfig');
        return ArrayUtil::getValue($configuration, $key, null);
    }
    
    /**
     * Get local value by key
     * @param string $key
     * @return type
     */
    public function getLocalValue($key)
    {
        $configuration = $this->getConfigurationByCode('storelocal', 'storeconfig');
        return ArrayUtil::getValue($configuration, $key, null);
    }
    
    /**
     * Get store images value.
     * @param string $key
     * @param string $defaultValue
     * @return string
     */
    public function getImageSetting($key, $defaultValue = null)
    {
        $configuration = $this->getConfigurationByCode('storeimage', 'storeconfig');
        if(!empty($configuration[$key]))
        {
            return $configuration[$key];
        }
        return $defaultValue;
    }
    
    /**
     * Get store value by key for store
     * @param string $key
     * @param string $code
     * @param string $category
     * @param int $storeId
     * @return array
     */
    public function getStoreValueByKey($key, $code, $category, $storeId = null)
    {
        $storeConfig = $this->getConfigurationByCode($code, $category, $storeId);
        return ArrayUtil::getValue($storeConfig, $key, null);
    }
}
