<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\dao;

use usni\UsniAdaptor;
use yii\caching\DbDependency;
/**
 * Implements data access functionality related to stores.
 *
 * @package usni\library\modules\stores\dao
 */
class StoreDAO
{
    /**
     * Get all stores.
     * @param string $language
     * @param integer $status
     * @return array
     */
    public static function getAll($language, $status = null)
    {
        $table      = UsniAdaptor::tablePrefix() . 'store';
        $trTable    = UsniAdaptor::tablePrefix() . 'store_translated';
        $dependency = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $table"]);
        $sql        = "SELECT st.*, stt.name FROM $table st, $trTable stt "
                    . "WHERE st.id = stt.owner_id AND stt.language = :lang";
        $params     = [];
        if($status !== null)
        {
            $sql .= " AND st.status = :status";
            $params[':status'] = $status;
        }
        $params[':lang'] = $language;
        return UsniAdaptor::app()->db->createCommand($sql, $params)->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get store by id
     * @param int $id
     * @param string $language  
     * @return array
     */
    public static function getById($id, $language)
    {
        $table      = UsniAdaptor::tablePrefix() . 'store';
        $trTable    = UsniAdaptor::tablePrefix() . 'store_translated';
        $dcTable    = UsniAdaptor::tablePrefix() . 'data_category';
        $dcTrTable  = UsniAdaptor::tablePrefix() . 'data_category_translated';
        $dependency = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $table"]);
        $sql        = "SELECT st.*, stt.name, stt.description, stt.metakeywords, stt.metadescription, dctr.name AS dataCategory 
                      FROM $table st, $trTable stt, $dcTable dc, $dcTrTable dctr WHERE st.id = :id AND st.id = stt.owner_id AND stt.language = :lan
                      AND st.data_category_id = dc.id AND dc.id = dctr.owner_id AND dctr.language = :lan2";
        return UsniAdaptor::app()->db->createCommand($sql, [':id' => $id, ':lan' => $language, ':lan2' => $language])->cache(0, $dependency)->queryOne();
    }
    
    /**
     * Get default store
     * @param int $id
     * @param string $language  
     * @return array
     */
    public static function getDefault($language)
    {
        $table      = UsniAdaptor::tablePrefix() . 'store';
        $trTable    = UsniAdaptor::tablePrefix() . 'store_translated';
        $sql        = "SELECT st.*, stt.name, stt.description, stt.metakeywords, stt.metadescription FROM $table st, $trTable stt WHERE st.is_default = :default AND st.id = stt.owner_id AND stt.language = :lan";
        return UsniAdaptor::app()->db->createCommand($sql, [':default' => 1, ':lan' => $language])->queryOne();
    }
    
    /**
     * Get configuration categories for the store
     * @param int $storeId
     * @return array
     */
    public static function getConfigCategories($storeId)
    {
        $table      = UsniAdaptor::tablePrefix() . 'store_configuration';
        $dependency = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $table"]);
        $sql        = "SELECT DISTINCT(category) FROM $table WHERE store_id = :sid";
        return UsniAdaptor::app()->db->createCommand($sql, [':sid' => $storeId])->cache(0, $dependency)->queryColumn();
    }
    
    /**
     * Get configuration by category for the store
     * @param string $category
     * @param int $storeId
     * @return array
     */
    public static function getConfigByCategory($category, $storeId)
    {
        $table      = UsniAdaptor::tablePrefix() . 'store_configuration';
        $sql        = "SELECT * FROM $table WHERE store_id = :sid AND category = :cat";
        $dependency = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $table"]);
        return UsniAdaptor::app()->db->createCommand($sql, [':sid' => $storeId, ':cat' => $category])->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get store's orders.
     * 
     * @param $sid int
     * @return array
     */
    public static function getOwner($sid)
    {
        $storeTable     = UsniAdaptor::tablePrefix() . 'store';
        $userTable      = UsniAdaptor::tablePrefix() . 'user';
        $personTable    = UsniAdaptor::tablePrefix() . 'person';
        $sql                = "SELECT tp.*, ut.username, ut.status, ut.timezone, ut.type
                               FROM $userTable ut,  $personTable tp, $storeTable st
                               WHERE st.id = :sid AND st.owner_id = ut.id AND ut.person_id = tp.id";
        $connection         = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':sid' => $sid])->queryOne();
    }
    
    /**
     * Get store address by type
     * @param int $storeId
     * @param int $type
     * @return type
     */
    public static function getStoreAddressByType($storeId, $type)
    {
        $tableName  = UsniAdaptor::tablePrefix() . 'address';
        $sql        = "SELECT * FROM $tableName WHERE relatedmodel = :rm AND relatedmodel_id = :rmid AND type = :type";
        $dependency = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $tableName"]);
        return UsniAdaptor::app()->db->createCommand($sql, [':rm' => 'Store', ':rmid' => $storeId, ':type' => $type])->cache(0, $dependency)->queryOne();
    }
    
    /**
     * Get store by id
     * @param int $id
     * @param string $language  
     * @return array
     */
    public static function getDataCategoryId($id)
    {
        $table      = UsniAdaptor::tablePrefix() . 'store';
        $dcTable    = UsniAdaptor::tablePrefix() . 'data_category';
        $dependency = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $table"]);
        $sql        = "SELECT st.*
                      FROM $table st, $dcTable dc WHERE st.id = :id AND st.data_category_id = dc.id";
        $record     = UsniAdaptor::app()->db->createCommand($sql, [':id' => $id])->cache(0, $dependency)->queryOne();
        return $record['data_category_id'];
    }
    
    /**
     * Get status.
     * @param integer $id
     * @return integer
     */
    public static function getStatus($id)
    {
        $table      = UsniAdaptor::tablePrefix() . 'store';
        $sql        = "SELECT st.status
                      FROM $table st WHERE st.id = :id";
        $record     = UsniAdaptor::app()->db->createCommand($sql, [':id' => $id])->queryOne();
        return $record['status'];
    }
}
