<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\business;

use usni\UsniAdaptor;
use usni\library\utils\CacheUtil;
use usni\library\models\Configuration;
use usni\library\modules\users\models\User;
/**
 * ConfigManager manages the data related to application configuration
 *
 * @package usni\library\business
 */
class ConfigManager extends Manager
{
    /**
     * @var string the name of the table storing application configuration.
     */
    public $table = '{{%configuration}}';
    
    /**
     * Insert or update configuration
     * @param string $module
     * @param string $key
     * @param string $value
     * @return array
     */
    public function insertOrUpdateConfiguration($module, $key, $value)
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
        $record = $this->checkAndGetConfiguration($module, $key);
        try
        {
            if($record === false)
            {
                $data   = [
                    'key'    => $key,
                    'value'  => $value,
                    'module' => $module,
                    'created_by' => $createdBy,
                    'created_datetime' => $createdDateTime,
                    'modified_by' => $modifiedBy,
                    'modified_datetime' => $modifiedDateTime
                ];
                UsniAdaptor::app()->db->createCommand()->insert($this->table, $data)->execute();
            }
            else
            {
                $data   = [
                    'value'  => $value,
                    'modified_by' => $modifiedBy,
                    'modified_datetime' => $modifiedDateTime
                ];
                UsniAdaptor::app()->db->createCommand()->update($this->table . ' tc', $data, 
                                                                'tc.module = :module AND tc.key = :key', 
                                                                [':module' => $module, ':key' => $key])->execute();
            }
            CacheUtil::delete('appconfig');
            return null;
        }
        catch (\yii\db\Exception $e)
        {
            return $e->getMessage();
        }
    }

    /**
     * Process insert or update configuration.
     * @param Model $model
     * @param string $module
     * @param array $excludedAttributes
     * @return void
     */
    public function processInsertOrUpdateConfiguration($model, $module, $excludedAttributes = [])
    {
        $errors = array();
        foreach($model->getAttributes() as $key => $value)
        {
            if($model instanceof \yii\db\ActiveRecord && $model->getPrimaryKey() == $key)
            {
                continue;
            }
            if(in_array($key, $excludedAttributes))
            {
                continue;
            }
            $errors = $this->insertOrUpdateConfiguration($module, $key, $value);
            if(!empty($errors))
            {
                $model->addErrors(array($key = $errors));
            }
        }
    }
    
    /**
     * Checks if configuration exist.
     * @param string $module
     * @param string $key
     * @return array
     */
    public function checkAndGetConfiguration($module, $key)
    {
        $tableName  = $this->table;
        $sql        = "SELECT * FROM $tableName tc WHERE tc.module = :module AND tc.key = :key";
        return UsniAdaptor::app()->db->createCommand($sql, [':module' => $module, ':key' => $key])->queryOne();
    }
    
    /**
     * Get value for the configuration.
     * @param string $module
     * @param string $key
     * @return string
     */
    public function getValue($module, $key)
    {
        $tableName  = $this->table;
        $configData = CacheUtil::get('appconfig');
        if($configData === false || !isset($configData[$module][$key]))
        {
            $sql    = "SELECT * FROM $tableName tc WHERE tc.module = :module AND tc.key = :key";
            $record = UsniAdaptor::app()->db->createCommand($sql, [':module' => $module, ':key' => $key])->queryOne();
            if($record === false)
            {
                return null;
            }
            return $record['value'];
        }
        else
        {
            return $configData[$module][$key];
        }
    }

    /**
     * Get module configuration.
     * @param string $module
     * @param bollean $cache
     * @return array
     */
    public function getModuleConfiguration($module, $cache = true)
    {
        $tableName  = $this->table;
        $configData = CacheUtil::get('appconfig');
        if($configData === false || !isset($configData[$module]))
        {
            $confData       = array();
            $sql            = "SELECT * FROM $tableName WHERE module = :module";
            $records        = UsniAdaptor::app()->db->createCommand($sql, [':module' => $module])->queryAll();
            foreach($records as $record)
            {
                $confData[$record['key']] = $record['value'];
            }
        }
        else
        {
           $confData = $configData[$module];
        }
        return $confData;
    }
    
    /**
     * Loads configuration in the database into cache.
     * 
     * @return void
     */
    public function load()
    {
        $configData = [];
        if(UsniAdaptor::app()->isInstalled())
        {
            $configData = CacheUtil::get('appconfig');
            if($configData === false)
            {
                $configData = [];
                $records    = Configuration::find()->asArray()->all();
                if(!empty($records))
                {
                    foreach($records as $record)
                    {
                        $configData[$record['module']][$record['key']] = $record['value'];
                    }
                }
                CacheUtil::set('appconfig', $configData);
            }
        }
    }
}