<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\dao;

use usni\UsniAdaptor;
use yii\caching\DbDependency;
/**
 * Implements data access functionality related to tax rule.
 *
 * @package taxes\dao
 */
class TaxRuleDAO
{
    /**
     * Get tax rule by attribute.
     * @param string $attribute
     * @param integer $value
     * @return array.
     */
    public static function getTaxRuleByAttribute($attribute, $value, $language)
    {
        $taxRuleTable           = UsniAdaptor::tablePrefix() . 'tax_rule';
        $trTaxRuleTable         = UsniAdaptor::tablePrefix() . 'tax_rule_translated';
        $taxRuleDetailsTable    = UsniAdaptor::tablePrefix() . 'tax_rule_details';
        $sql    = "SELECT tr.*, trt.name, trd.tax_rule_id, trd.product_tax_class_id, trd.customer_group_id,  trd.tax_zone_id
                   FROM $taxRuleTable tr, $trTaxRuleTable trt, $taxRuleDetailsTable trd
                   WHERE trd." . $attribute  . "= :ptci AND trd.tax_rule_id = tr.id AND tr.id = trt.owner_id AND trt.language = :lang";
        
        $connection             = UsniAdaptor::app()->getDb();
        $params                 = [':ptci' => $value, ':lang' => $language];
        $records                = $connection->createCommand($sql, $params)->queryAll();
        return $records;
    }
    
    /**
     * Get all tax rules.
     * @param string $language
     * @return array
     */
    public static function getAll($language)
    {
        $table      = UsniAdaptor::tablePrefix() . 'tax_rule';
        $trTable    = UsniAdaptor::tablePrefix() . 'tax_rule_translated';
        $dependency = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $table"]);
        $sql        = "SELECT tr.*, trt.name FROM $table tr, $trTable trt "
                    . "WHERE tr.id = trt.owner_id AND trt.language = :lang";
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
        $table      = UsniAdaptor::tablePrefix() . 'tax_rule';
        $trTable    = UsniAdaptor::tablePrefix() . 'tax_rule_translated';
        $sql        = "SELECT tr.*, trt.name FROM $table tr, $trTable trt "
                    . "WHERE tr.id = :id AND trt.owner_id = tr.id AND trt.language = :lang";
        return UsniAdaptor::app()->db->createCommand($sql, [':id' => $id, ':lang' => $language])->queryOne();
    }
}
