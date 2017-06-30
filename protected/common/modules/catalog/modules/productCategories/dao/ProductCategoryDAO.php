<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace productCategories\dao;

use usni\UsniAdaptor;
use yii\caching\DbDependency;
use productCategories\models\ProductCategory;
/**
 * Implements data access functionality related to product category.
 *
 * @package productCategories\dao
 */
class ProductCategoryDAO
{
     /**
     * Get children for a parent product category id.
     * @param int $parentId
     * @param string $language
      * @param int $dataCategoryId
     * @return array
     */
    public static function getChildrens($parentId, $language, $dataCategoryId)
    {
        $categoryTable      = UsniAdaptor::tablePrefix() . 'product_category';
        $trCtegoryTable     = UsniAdaptor::tablePrefix() . 'product_category_translated';
        $dependency         = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $categoryTable"]);
        $sql                = "SELECT tpc.*, tpct.name, tpct.description, tpct.alias FROM $categoryTable tpc, $trCtegoryTable tpct
                               WHERE tpc.parent_id = :pid AND tpc.data_category_id = :dci AND tpc.status = :status AND tpc.id = tpct.owner_id AND tpct.language = :lang";
        $params             = [':pid' => $parentId, ':lang' => $language, ':dci' => $dataCategoryId, ':status' => ProductCategory::STATUS_ACTIVE];
        return UsniAdaptor::app()->db->createCommand($sql, $params)->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get all categories by data category.
     * @param integer $dataCategoryId
     * @param integer $status
     * @return array
     */
    public static function getAllByDataCategory($dataCategoryId, $status = null)
    {
        $categoryTable          = UsniAdaptor::tablePrefix() . 'product_category';
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $categoryTable"]);
        $sql                    = "SELECT ct.*
                                   FROM $categoryTable ct
                                   WHERE ct.data_category_id = :dci";
        $params                 = [];
        if($status != null)
        {
            $sql .= " AND ct.status = :status";
            $params[':status'] = $status;
        }
        $sql .= " ORDER BY ct.path";
        $params[':dci']         = $dataCategoryId;
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, $params)->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get all product categories.
     * @param string $language
     * @param integer $dataCategoryId
     * @return array
     */
    public static function getAll($language, $dataCategoryId)
    {
        $table      = UsniAdaptor::tablePrefix() . 'product_category';
        $trTable    = UsniAdaptor::tablePrefix() . 'product_category_translated';
        $dependency = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $table"]);
        $sql        = "SELECT pa.*, pat.name FROM $table pa, $trTable pat "
                    . "WHERE pa.data_category_id = :dci AND pa.id = pat.owner_id AND pat.language = :lang ORDER BY pa.path";
        return UsniAdaptor::app()->db->createCommand($sql, [':dci' => $dataCategoryId, ':lang' => $language])->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get by id.
     * @param integer $id
     * @param string $language
     * @return array
     */
    public static function getById($id, $language)
    {
        $table      = UsniAdaptor::tablePrefix() . 'product_category';
        $trTable    = UsniAdaptor::tablePrefix() . 'product_category_translated';
        $sql        = "SELECT pa.*, pat.name, pat.description, pat.alias, pat.metakeywords, pat.metadescription FROM $table pa, $trTable pat "
                    . "WHERE pa.id = :id AND pat.owner_id = pa.id AND pat.language = :lang";
        return UsniAdaptor::app()->db->createCommand($sql, [':id' => $id, ':lang' => $language])->queryOne();
    }
    
    /**
     * Get parent name.
     * @param integer $parentId
     * @param string $language
     * @return array
     */
    public static function getParentName($parentId, $language)
    {
        $connection             = UsniAdaptor::app()->getDb();
        $tableName              = $connection->tablePrefix . 'product_category';
        $trTableName            = $connection->tablePrefix . 'product_category_translated';
        $sql                    = "SELECT pt.*
                                   FROM $tableName p, $trTableName pt
                                   WHERE p.id = :id AND pt.owner_id = p.id AND pt.language = :lang";
        $data = $connection->createCommand($sql, [':id' => $parentId, ':lang' => $language])->queryOne();
        if(!empty($data))
        {
            return $data['name'];
        }
    }
    
    /**
     * Get top menu categories by parent.
     * @param int $parentId
     * @param int $storeDataCategory
     * @param string $language
     * @return array
     */
    public static function getTopMenuCategoriesByParent($parentId, $storeDataCategory, $language)
    {
        $connection             = UsniAdaptor::app()->getDb();
        $tableName              = UsniAdaptor::tablePrefix() . 'product_category';
        $peTableName            = UsniAdaptor::tablePrefix() . 'product_category_translated';
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $tableName"]);
        $sql                    = "SELECT pc.*, pct.name, pct.alias, pct.metakeywords, pct.metadescription, pct.description
                                   FROM $tableName pc, $peTableName pct 
                                   WHERE pc.data_category_id = :id AND pc.parent_id = :pid AND pc.displayintopmenu = :dtm 
                                   AND pc.id = pct.owner_id AND pct.language = :lan";
        return $connection->createCommand($sql, [':id' => $storeDataCategory, ':pid' => $parentId, ':lan' => $language, ':dtm' => 1])
                          ->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get product categories
     * @param integer $productId
     * @param string $language
     * @return array
     */
    public static function getCategoriesByProduct($productId, $language)
    {
        $categoryTableName  = UsniAdaptor::tablePrefix() . 'product_category';
        $mappingTableName   = UsniAdaptor::tablePrefix() . 'product_category_mapping';
        $trTableName        = UsniAdaptor::tablePrefix() . 'product_category_translated';
        $dependency         = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $mappingTableName"]);
        $sql                = "SELECT c.*, ct.name 
                                   FROM $categoryTableName c, $mappingTableName cm, $trTableName ct 
                                   WHERE cm.product_id = :pid AND cm.category_id = c.id AND c.id = ct.owner_id AND ct.language = :lan";
        $connection         = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':pid' => $productId, ':lan' => $language])->cache(0, $dependency)->queryAll();
    }
}
