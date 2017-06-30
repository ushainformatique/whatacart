<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\business;

use usni\UsniAdaptor;
use usni\library\modules\users\models\User;
use usni\library\utils\CacheUtil;
use common\modules\stores\dao\StoreDAO;
use common\modules\stores\models\StoreConfiguration;
use usni\library\utils\ArrayUtil;
/**
 * ConfigManager for store
 *
 * @package common\modules\stores\business
 */
class ConfigManager extends \common\business\Manager
{
    use \common\modules\stores\traits\StoreConfigTrait;
    
    /**
     * Configuration for the selected store
     * @var array 
     */
    public $config;
    
    /**
     * inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->config = $this->getConfiguration();
    }
    
    /**
     * Insert store configuration
     * @param Model|Array $model
     * @param integer $storeId
     * @param string $code
     * @param string $category
     */
    public function batchInsertStoreConfiguration($model, $storeId, $code, $category)
    {
        if($this->userId == null)
        {
            //Install time
            $createdBy = $modifiedBy = User::SUPER_USER_ID;
        }
        else
        {
            $createdBy = $modifiedBy = $this->userId;
        }
        $createdDateTime = $modifiedDateTime = date('Y-m-d H:i:s');
        $table       = UsniAdaptor::tablePrefix(). 'store_configuration';
        if(is_object($model))
        {
            $attributes  = $model->getAttributes();
        }
        else
        {
            $attributes  = $model;
        }
        $data        = [];
        $columns     = ['store_id', 'category', 'code', 'key', 'value', 'created_by', 'created_datetime', 'modified_by', 'modified_datetime'];
        $excludedAttributes = static::getExcludedAttributesFromStoreConfig();
        foreach($attributes as $key => $value)
        {
            if(!in_array($key, $excludedAttributes))
            {
                $data[] = [$storeId, $category, $code, $key, $value, $createdBy, $createdDateTime, $modifiedBy, $modifiedDateTime];
            }
        }
        UsniAdaptor::app()->db->createCommand()->batchInsert($table, $columns, $data)->execute();
        $this->invalidateCache($storeId);
    }
    
    /**
     * Get excluded attributes from store configuration
     * @return array
     */
    public static function getExcludedAttributesFromStoreConfig()
    {
        return ['logoUploadInstance', 'logoSavedImage', 'iconUploadInstance', 'iconSavedImage'];
    }
    
    /**
     * Update store configuration
     * @param Model|Array $model
     * @param string $code
     * @param int $storeId
     */
    public function updateStoreConfiguration($model, $code, $storeId)
    {
        if($this->userId == null)
        {
            $modifiedBy = User::SUPER_USER_ID;
        }
        else
        {
            $modifiedBy = $this->userId;
        }
        
        $modifiedDateTime = date('Y-m-d H:i:s');
        $table       = UsniAdaptor::tablePrefix(). 'store_configuration';
        if(is_array($model))
        {
            $attributes = $model;
        }
        else
        {
            $attributes  = $model->getAttributes();
        }
        $excludedAttributes = static::getExcludedAttributesFromStoreConfig();
        foreach($attributes as $key => $value)
        {
            if(!in_array($key, $excludedAttributes))
            {
                $sql         = "UPDATE $table tc SET value = :value, modified_by = :mid, modified_datetime = :mdt WHERE tc.store_id = :sid AND tc.code = :code AND tc.key = :key";
                UsniAdaptor::app()->db->createCommand($sql, [':sid' => $storeId, ':code' => $code, ':key' => $key, ':value' => $value,
                                                            ':mid' => $modifiedBy, ':mdt' => $modifiedDateTime])->execute();
            }
        }
        $this->invalidateCache($storeId);
    }
    
    /**
     * Delete store configuration for a code and category
     * @param string $code
     * @param string $category
     */
    public function deleteStoreConfiguration($code, $category)
    {
        StoreConfiguration::deleteAll('code = :code AND category =:category AND store_id = :sid', 
                                                        [':category' => $category, ':code' => $code, ':sid' => $this->selectedStoreId]);
        $this->invalidateCache($this->selectedStoreId);
    }
    
    /**
     * Insert store configuration
     * @param string $code
     * @param string $category
     * @param string $key
     * @param string $value
     * @param int $storeId
     */
    public function insertStoreConfiguration($code, $category, $key, $value, $storeId)
    {
        if($this->userId == null)
        {
            //Install time
            $createdBy = $modifiedBy = User::SUPER_USER_ID;
        }
        else
        {
            $createdBy = $modifiedBy = $this->userId;
        }
        $createdDateTime = $modifiedDateTime = date('Y-m-d H:i:s');
        $table       = UsniAdaptor::tablePrefix(). 'store_configuration';
        $columns     = ['store_id' => $storeId, 'code' => $code, 'category' => $category, 'key' => $key, 'value' => $value, 'created_by' => $createdBy, 
                        'created_datetime' => $createdDateTime, 'modified_by' => $modifiedBy, 'modified_datetime' => $modifiedDateTime];
        UsniAdaptor::app()->db->createCommand()->insert($table, $columns)->execute();
        $this->invalidateCache($storeId);
    }
    
    /**
     * Insert or update store configuration
     * @param string $code
     * @param string $category
     * @param string $key
     * @param string $value
     * @param int $storeId
     */
    public function insertOrUpdateConfiguration($code, $category, $key, $value, $storeId)
    {
        $record = $this->checkAndGetConfigurationIfExist($code, $category, $key, $storeId);
        try
        {
            if($record == false)
            {
                $this->insertStoreConfiguration($code, $category, $key, $value, $storeId);
            }
            else
            {
                $this->updateStoreConfiguration([$key => $value], $code, $storeId);
            }
            $this->invalidateCache($storeId);            
            return null;
        }
        catch (\yii\db\Exception $e)
        {
            return $e->getMessage();
        }
    }
    
    /**
     * Checks if configuration exist.
     * @param string $code
     * @param string $category
     * @param string $key
     * @param int $storeId
     * @return array
     */
    public function checkAndGetConfigurationIfExist($code, $category, $key, $storeId)
    {
        return StoreConfiguration::find()->where("store_id = :sid AND category = :cat AND code = :code AND `key` = :key", 
                                                 [':sid' => $storeId, ':key' => $key, ':code' => $code, ':cat' => $category])->one();
    }
    
    /**
     * Process insert or update configuration.
     * @param Model|Array $model
     * @param string $code
     * @param string $category
     * @param int $storeId
     * @param array $excludedAttributes
     * @return void
     */
    public function processInsertOrUpdateConfiguration($model, $code, $category, $storeId, $excludedAttributes = [])
    {
        if(is_array($model))
        {
            $attributes = $model;
        }
        else
        {
            $attributes  = $model->getAttributes();
        }
        foreach($attributes as $key => $value)
        {
            if(in_array($key, $excludedAttributes))
            {
                continue;
            }
            $this->insertOrUpdateConfiguration($code, $category, $key, $value, $storeId);
        }
        $this->invalidateCache($storeId);
    }
    
    /**
     * Get store configuration
     * @param int $storeId This is needed from store business manager. In other cases, selected store id would be used
     * @return array
     */
    public function getConfiguration($storeId = null)
    {
        $data       = [];
        if($storeId == null)
        {
            $storeId    = $this->selectedStoreId;
        }
        if($storeId != null)
        {
            $key     = $storeId . '_store_config';
            $data    = CacheUtil::get($key);
            if(empty($data))
            {
                $categories = StoreDAO::getConfigCategories($storeId);
                foreach($categories as $category)
                {
                    $configByCategory   = StoreDAO::getConfigByCategory($category, $storeId);
                    $configMap          = ArrayUtil::map($configByCategory, 'key', 'value', 'code');
                    $data[$category]    = $configMap;
                }
                CacheUtil::set($key, $data);
            }
        }
        return $data;
    }
    
    /**
     * Invalidate cache
     * @param integer $storeId
     */
    public function invalidateCache($storeId)
    {
        CacheUtil::delete($storeId . '_store_config');
    }
}
