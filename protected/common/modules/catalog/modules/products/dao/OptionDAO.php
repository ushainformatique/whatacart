<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\dao;

use usni\UsniAdaptor;
use yii\caching\DbDependency;
/**
 * Implements data access functionality related to product options
 *
 * @package products\dao
 */
class OptionDAO extends \yii\base\Component
{
    /**
     * Get option mapping details
     * @param int $productId
     * @param int $optionId
     * @param int $optionValueId
     * @return array
     */
    public static function getOptionMappingDetails($productId, $optionId, $optionValueId)
    {
        $mappingTableName           = UsniAdaptor::tablePrefix() . 'product_option_mapping';
        $mappingDetailsTableName    = UsniAdaptor::tablePrefix() . 'product_option_mapping_details';
        $sql                        = "SELECT tpomd.*
                                        FROM $mappingTableName AS tpom, $mappingDetailsTableName AS tpomd
                                        WHERE tpom.product_id = :pid AND tpom.option_id = :oid AND tpom.id = tpomd.mapping_id 
                                        AND tpomd.option_value_id = :ovi";
        $connection                 = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':pid' => $productId, ':oid' => $optionId, ':ovi' => $optionValueId])->queryOne();
    }
    
    /**
     * Get product options
     * @param int $productId
     * @param string $language
     * @param int $required
     * @return array
     */
    public static function getOptions($productId, $language, $required = 1)
    {
        $poTableName        = UsniAdaptor::tablePrefix() . 'product_option';
        $poTrTableName      = UsniAdaptor::tablePrefix() . 'product_option_translated';
        $mappingTableName   = UsniAdaptor::tablePrefix() . 'product_option_mapping';
        $sql                = "SELECT tpo.id AS optionId, tpoTr.display_name 
                                FROM $mappingTableName AS tpom, $poTableName AS tpo, $poTrTableName AS tpoTr
                                WHERE tpom.product_id = :pid AND tpom.required = :req AND tpom.option_id = tpo.id AND tpo.id = tpoTr.owner_id
                                AND tpoTr.language = :lan";
        $connection           = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':pid' => $productId, ':lan' => $language, ':req' => $required])->queryAll();
    }
    
    /**
     * Get option data by option value
     * @param int $optionValueId
     * @param string $language
     * @return array
     */
    public static function getOptionDataByOptionValueId($optionValueId, $language)
    {
        $po         = UsniAdaptor::tablePrefix() . 'product_option';
        $poTr       = UsniAdaptor::tablePrefix() . 'product_option_translated';
        $pov        = UsniAdaptor::tablePrefix() . 'product_option_value';
        $povTr      = UsniAdaptor::tablePrefix() . 'product_option_value_translated';
        $sql        = "SELECT po.id, poTr.name, povTr.value FROM $po AS po, $poTr AS poTr, $pov AS pov, $povTr AS povTr
                       WHERE pov.id = :id AND pov.id = povTr.owner_id AND povTr.language = :lan2
                       AND pov.option_id = po.id AND po.id = poTr.owner_id AND poTr.language = :lan1 
                      ";
        $connection = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':id' => $optionValueId, ':lan1' => $language, ':lan2' => $language])->queryOne();
    }
    
    /**
     * Get assigned options for the product
     * @param int $productId
     * @param string $language
     * @return array
     */
    public static function getAssignedOptions($productId, $language)
    {
        $ovTrTableName  = UsniAdaptor::tablePrefix(). 'product_option_value_translated';
        $ovTableName    = UsniAdaptor::tablePrefix(). 'product_option_value';
        $poTableName    = UsniAdaptor::tablePrefix(). 'product_option';
        $poTrTableName  = UsniAdaptor::tablePrefix(). 'product_option_translated';
        $mappingDetailsTableName = UsniAdaptor::tablePrefix(). 'product_option_mapping_details';
        $mappingTableName   = UsniAdaptor::tablePrefix(). 'product_option_mapping';
        $sql            = "SELECT tpom.id, tpomd.price, tpomd.price_prefix, tpov.id as optionValueId, 
                            tpovTr.value, tpo.type, tpo.id AS optionId, tpoTr.display_name, tpom.required,
                            tpomd.weight, tpomd.weight_prefix, tpomd.quantity, tpomd.subtract_stock
                            FROM $mappingTableName tpom, $mappingDetailsTableName tpomd, $ovTableName tpov,
                                      $ovTrTableName tpovTr, $poTableName tpo, $poTrTableName tpoTr 
                            WHERE tpom.product_id = :pid AND tpom.id = tpomd.mapping_id AND tpomd.option_value_id = tpov.id AND tpov.id = tpovTr.owner_id 
                                  AND tpovTr.language = :lan AND tpov.option_id = tpo.id AND tpo.id = tpoTr.owner_id and tpoTr.language = :lan
                         ";
        $connection     = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':pid' => $productId, ':lan' => $language])->queryAll();
    }
    
    /**
     * Get assigned product option values.
     * @param int $productId
     * @param int $optionId
     * @param string $language
     * @return int
     */
    public static function getAssignedOptionValues($productId, $optionId, $language)
    {
        $ovTrTableName  = UsniAdaptor::tablePrefix(). 'product_option_value_translated';
        $ovTableName    = UsniAdaptor::tablePrefix(). 'product_option_value';
        $mappingDetailsTableName = UsniAdaptor::tablePrefix(). 'product_option_mapping_details';
        $mappingTableName   = UsniAdaptor::tablePrefix(). 'product_option_mapping';
        $sql            = "SELECT tpomd.*, tpom.product_id, tpom.option_id, tpovt.value
                            FROM $mappingTableName tpom, $mappingDetailsTableName tpomd, $ovTableName tpov,
                                      $ovTrTableName tpovt 
                            WHERE tpom.product_id = :pid AND tpom.option_id = :oid 
                            AND tpom.id = tpomd.mapping_id AND tpomd.option_value_id = tpov.id 
                            AND tpov.id = tpovt.owner_id 
                            AND tpovt.language = :lan
                         ";
        $connection     = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':pid' => $productId, ':oid' => $optionId, ':lan' => $language])->queryAll();
    }
    
    /**
     * Get option values by option
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
        $connection     = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':oid' => $optionId, ':lan' => $language])->cache(0, $dependency)->queryAll();
    }
}
