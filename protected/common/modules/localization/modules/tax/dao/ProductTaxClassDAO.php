<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\dao;

use usni\UsniAdaptor;
use yii\caching\DbDependency;
/**
 * Implements data access functionality related to product tax class.
 *
 * @package taxes\dao
 */
class ProductTaxClassDAO
{
    /**
     * Get all product tax classes.
     * @param string $language
     * @return array
     */
    public static function getAll($language)
    {
        $table      = UsniAdaptor::tablePrefix() . 'product_tax_class';
        $trTable    = UsniAdaptor::tablePrefix() . 'product_tax_class_translated';
        $dependency = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $table"]);
        $sql        = "SELECT pt.*, ptt.name, ptt.description FROM $table pt, $trTable ptt "
                    . "WHERE pt.id = ptt.owner_id AND ptt.language = :lang";
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
        $table      = UsniAdaptor::tablePrefix() . 'product_tax_class';
        $trTable    = UsniAdaptor::tablePrefix() . 'product_tax_class_translated';
        $sql        = "SELECT pt.*, ptt.name, ptt.description FROM $table pt, $trTable ptt "
                    . "WHERE pt.id = :id AND ptt.owner_id = pt.id AND ptt.language = :lang";
        return UsniAdaptor::app()->db->createCommand($sql, [':id' => $id, ':lang' => $language])->queryOne();
    }
    
    /**
     * Get product tax class name by tax rule id
     * @param integer $id tax rule id
     * @param string $language
     * @return array
     */
    public static function getNameByTaxRuleId($id, $language)
    {
        $productTaxClassTable       = UsniAdaptor::tablePrefix() . 'product_tax_class';
        $trProductTaxClassTable     = UsniAdaptor::tablePrefix() . 'product_tax_class_translated';
        $taxRuleDetailsTable        = UsniAdaptor::tablePrefix() . 'tax_rule_details';
        $sql                        = "SELECT DISTINCT tptt.name
                                       FROM $productTaxClassTable tpt,  $trProductTaxClassTable tptt, $taxRuleDetailsTable ttrd
                                       WHERE ttrd.tax_rule_id = :trid AND ttrd.product_tax_class_id = tpt.id AND tpt.id = tptt.owner_id 
                                       AND tptt.language = :lang";
        $connection    = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':trid' => $id, ':lang' => $language])->queryAll();
    }
}
