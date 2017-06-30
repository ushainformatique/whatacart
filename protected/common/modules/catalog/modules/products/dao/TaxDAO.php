<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\dao;

use usni\library\modules\users\models\Address;
use usni\UsniAdaptor;
use yii\db\Query;
use taxes\models\Zone;
use yii\caching\DbDependency;
/**
 * Implements data access functionality related to product options
 *
 * @package products\dao
 */
class TaxDAO extends \yii\base\Component
{
    /**
     * Get zone by address
     * @param Address $address
     * @param string $language
     * @return Zone
     */
    public static function getZoneByAddress($address, $language)
    {
        if($address != null)
        {
            $country = static::getCountryByCode($address['country'], $language);
            if(!empty($country['id']))
            {
                $tableName  = UsniAdaptor::tablePrefix(). 'zone';
                $query      = new Query();
                $zone       = $query->select('*')->from($tableName)
                              ->where('country_id = :cid AND zip = :zip AND is_zip_range = :izr', 
                                           [':cid' => $country['id'], ':zip' => $address['postal_code'], ':izr' => 0])->one();
                if(empty($zone))
                {
                    $query      = new Query();
                    $zone       = $query->select('*')->from($tableName)
                                  ->where('country_id = :cid AND (:zip BETWEEN from_zip AND to_zip) AND is_zip_range = :izr', 
                                           [':cid' => $country['id'], ':zip' => $address['postal_code'], ':izr' => 1])->one();
                    if(empty($zone))
                    {
                        return null;
                    }
                }
                return $zone;
            }                
        }
        return null;
    }
    
    /**
     * Get country by code
     * @param string $code
     * @return array
     */
    public static function getTaxRules($taxClass, $zoneId, $basedOn, $customerGroups)
    {
        $groups                 = implode(',', $customerGroups);
        $taxRuleDetailsTable    = UsniAdaptor::tablePrefix() . 'tax_rule_details';
        $taxRuleTable           = UsniAdaptor::tablePrefix() . 'tax_rule';
        $sql                    = "SELECT ttrule.type, SUM(ttrule.value) AS value, ttrule.based_on
                                   FROM $taxRuleDetailsTable ttrd, $taxRuleTable ttrule
                                   WHERE ttrd.product_tax_class_id = :pid AND (ttrd.customer_group_id IN ($groups))
                                   AND ttrd.tax_zone_id = :zid AND ttrd.tax_rule_id = ttrule.id 
                                   AND ttrule.based_on = :basedOn GROUP BY ttrule.type";
        $connection             = UsniAdaptor::app()->getDb();
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $taxRuleTable"]);
        return $connection->createCommand($sql, [':pid' => $taxClass, ':zid' => $zoneId, ':basedOn' => $basedOn])->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get country by code
     * @param string $code
     * @return array
     */
    public static function getCountryByCode($code, $language)
    {
        $tableName        = UsniAdaptor::tablePrefix() . 'country';
        $trTableName      = UsniAdaptor::tablePrefix() . 'country_translated';
        $sql              = "SELECT c.*, ctr.name
                             FROM $tableName c, $trTableName ctr
                             WHERE c.iso_code_2 = :code AND ctr.language = :lan";
        $connection       = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':code' => $code, ':lan' => $language])->queryOne();
    }
}