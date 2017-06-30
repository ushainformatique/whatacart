<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\dao;

use usni\UsniAdaptor;
use yii\caching\DbDependency;
/**
 * Implements data access functionality related to product attribute.
 *
 * @package products\dao
 */
class ProductAttributeDAO
{
    /**
     * Get all product attributes.
     * @param string $language
     * @return array
     */
    public static function getAll($language)
    {
        $table      = UsniAdaptor::tablePrefix() . 'product_attribute';
        $trTable    = UsniAdaptor::tablePrefix() . 'product_attribute_translated';
        $dependency = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $table"]);
        $sql        = "SELECT pa.*, pat.name FROM $table pa, $trTable pat "
                    . "WHERE pa.id = pat.owner_id AND pat.language = :lang";
        return UsniAdaptor::app()->db->createCommand($sql, [':lang' => $language])->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get by id.
     * @param integer $id
     * @param string $language
     * @return array
     */
    public static function getById($id, $language)
    {
        $table      = UsniAdaptor::tablePrefix() . 'product_attribute';
        $trTable    = UsniAdaptor::tablePrefix() . 'product_attribute_translated';
        $sql        = "SELECT pa.*, pat.name FROM $table pa, $trTable pat "
                    . "WHERE pa.id = :id AND pat.owner_id = pa.id AND pat.language = :lang";
        return UsniAdaptor::app()->db->createCommand($sql, [':id' => $id, ':lang' => $language])->queryOne();
    }
    
    /**
     * Get attributes for product
     * @param integer $productId
     * @param string $language
     * @return array
     */
    public static function getAttributesByProduct($productId, $language)
    {
        $attributeTable       = UsniAdaptor::tablePrefix() . 'product_attribute';
        $attributeTranslatedTable = UsniAdaptor::tablePrefix() . 'product_attribute_translated';
        $mappingTable         = UsniAdaptor::tablePrefix() . 'product_attribute_mapping';
        $groupTrTable         = UsniAdaptor::tablePrefix() . 'product_attribute_group_translated';
        $sql                  = "SELECT pa.* , pat.name, pam.attribute_value, pagtr.name AS groupName FROM $attributeTable pa, $attributeTranslatedTable pat, $mappingTable pam, 
                                $groupTrTable pagtr WHERE pam.product_id = :id AND pam.attribute_id = pa.id AND pa.id = pat.owner_id 
                                AND pat.language = :lan AND pa.attribute_group = pagtr.owner_id AND pagtr.language = :lan2";
        $connection           = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':id' => $productId, ':lan' => $language, ':lan2' => $language])->queryAll();
    }
}
