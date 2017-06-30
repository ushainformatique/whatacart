<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\dao;

use usni\UsniAdaptor;
use yii\caching\DbDependency;
/**
 * Implements data access functionality related to product option.
 *
 * @package products\dao
 */
class ProductOptionDAO
{
    /**
     * Get all product options.
     * @param string $language
     * @return array
     */
    public static function getAll($language)
    {
        $table      = UsniAdaptor::tablePrefix() . 'product_option';
        $trTable    = UsniAdaptor::tablePrefix() . 'product_option_translated';
        $dependency = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $table"]);
        $sql        = "SELECT po.*, pot.name, pot.display_name FROM $table po, $trTable pot "
                    . "WHERE po.id = pot.owner_id AND pot.language = :lang";
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
        $table      = UsniAdaptor::tablePrefix() . 'product_option';
        $trTable    = UsniAdaptor::tablePrefix() . 'product_option_translated';
        $sql        = "SELECT po.*, pot.name, pot.display_name FROM $table po, $trTable pot "
                    . "WHERE po.id = :id AND pot.owner_id = po.id AND pot.language = :lang";
        return UsniAdaptor::app()->db->createCommand($sql, [':id' => $id, ':lang' => $language])->queryOne();
    }
    
    /**
     * Get product option values
     * @param int $optionId
     * @param string $language
     * @return array
     */
    public static function getOptionValues($optionId, $language)
    {
        $ovTable        = UsniAdaptor::tablePrefix() . 'product_option_value';
        $ovTrTable      = UsniAdaptor::tablePrefix() . 'product_option_value_translated';
        $dependency     = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $ovTable"]);
        $sql            = "SELECT ov.*, ovTr.value 
                           FROM $ovTable ov, $ovTrTable ovTr WHERE ov.option_id = :oid AND ov.id = ovTr.owner_id AND ovTr.language = :lan";
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':oid' => $optionId, ':lan' => $language])->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get option value record
     * @param string $optionValue
     * @param int $optionId
     * @param string $language
     * @return array|false
     */
    public static function getOptionValueRecord($optionValue, $optionId, $language)
    {
        $tableName      = UsniAdaptor::tablePrefix(). 'product_option_value';
        $trTableName    = UsniAdaptor::tablePrefix(). 'product_option_value_translated';
        $sql            = "SELECT * FROM $tableName pov, $trTableName povt WHERE povt.value = :value AND povt.owner_id = pov.id "
                           . "AND povt.language = :lan AND pov.option_id = :optionId";
        return UsniAdaptor::app()->db->createCommand($sql, [':value' => $optionValue, ':lan' => $language, 
                          ':optionId' => $optionId])->queryOne();
    }
}