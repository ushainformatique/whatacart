<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\dao;

use usni\UsniAdaptor;
use yii\caching\DbDependency;
/**
 * Implements data access functionality related to zone.
 *
 * @package taxes\dao
 */
class ZoneDAO
{
    /**
     * Get all zones.
     * @param string $language
     * @return array
     */
    public static function getAll($language)
    {
        $table      = UsniAdaptor::tablePrefix() . 'zone';
        $trTable    = UsniAdaptor::tablePrefix() . 'zone_translated';
        $dependency = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $table"]);
        $sql        = "SELECT z.*, zt.name, zt.description FROM $table z, $trTable zt "
                    . "WHERE z.id = zt.owner_id AND zt.language = :lang";
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
        $table      = UsniAdaptor::tablePrefix() . 'zone';
        $trTable    = UsniAdaptor::tablePrefix() . 'zone_translated';
        $sql        = "SELECT z.*, zt.name, zt.description FROM $table z, $trTable zt "
                    . "WHERE z.id = :id AND zt.owner_id = z.id AND zt.language = :lang";
        return UsniAdaptor::app()->db->createCommand($sql, [':id' => $id, ':lang' => $language])->queryOne();
    }
    
    /**
     * Get zone with zip range.
     * @param Zone $zone
     * @return array
     */
    public static function getZoneWithZipRange($zone)
    {
        $zoneTable              = UsniAdaptor::tablePrefix() . 'zone';
        $trZoneTable            = UsniAdaptor::tablePrefix() . 'zone_translated';
        $trCountryTable         = UsniAdaptor::tablePrefix() . 'country_translated';
        $trStateTable           = UsniAdaptor::tablePrefix() . 'state_translated';
        $sql    = "SELECT zt.*, tzt.name, tct.name as country_name, tst.name as state_name
                  FROM $zoneTable zt, $trZoneTable tzt, $trCountryTable tct, $trStateTable tst
                  WHERE zt.country_id = :cid AND zt.state_id = :sid AND zt.from_zip = :fzip AND zt.to_zip = :tzip AND zt.id = tzt.owner_id AND tzt.name = :name AND tzt.language = :lang AND tct.owner_id = :coid AND tct.language = :clang AND tst.owner_id = :soid AND tst.language = :slang";
        $connection     = UsniAdaptor::app()->getDb();
        $params         = [':cid' =>  $zone->country_id, ':sid' => $zone->state_id, ':fzip' => $zone->from_zip, ':tzip' => $zone->to_zip, 
                           ':name' => $zone->name, ':lang' => $zone->language, ':coid' => $zone->country_id, ':clang' => $zone->language, 
                           ':soid' => $zone->state_id, ':slang' => $zone->language];
        return $connection->createCommand($sql, $params)->queryOne();
    }
    
    /**
     * Get zone with zip.
     * @param Zone $zone
     * @return array
     */
    public static function getZoneWithZip($zone)
    {
        $zoneTable              = UsniAdaptor::tablePrefix() . 'zone';
        $trZoneTable            = UsniAdaptor::tablePrefix() . 'zone_translated';
        $trCountryTable         = UsniAdaptor::tablePrefix() . 'country_translated';
        $trStateTable           = UsniAdaptor::tablePrefix() . 'state_translated';
        $sql    = "SELECT zt.*, tzt.name, tct.name as country_name, tst.name as state_name
                  FROM $zoneTable zt, $trZoneTable tzt, $trCountryTable tct, $trStateTable tst
                  WHERE zt.country_id = :cid AND zt.state_id = :sid AND zt.zip = :zip AND zt.id = tzt.owner_id AND tzt.name = :name AND tzt.language = :lang AND tct.owner_id = :coid AND tct.language = :clang AND tst.owner_id = :soid AND tst.language = :slang";
        $connection     = UsniAdaptor::app()->getDb();
        $params         = [':cid' =>  $zone->country_id, ':sid' => $zone->state_id, ':zip' => $zone->zip, 
                           ':name' => $zone->name, ':lang' => $zone->language, ':coid' => $zone->country_id, ':clang' => $zone->language, 
                           ':soid' => $zone->state_id, ':slang' => $zone->language];
        return $connection->createCommand($sql, $params)->queryOne();
    }
    
    /**
     * Get zone name by tax rule id
     * @param integer $id tax rule id
     * @param string $language
     * @return array
     */
    public static function getNameByTaxRuleId($id, $language)
    {
        $zoneTable       = UsniAdaptor::tablePrefix() . 'zone';
        $trZoneTable     = UsniAdaptor::tablePrefix() . 'zone_translated';
        $taxRuleDetailsTable        = UsniAdaptor::tablePrefix() . 'tax_rule_details';
        $sql                        = "SELECT DISTINCT zt.name
                                       FROM $zoneTable z,  $trZoneTable zt, $taxRuleDetailsTable ttrd
                                       WHERE ttrd.tax_rule_id = :trid AND ttrd.tax_zone_id = z.id AND z.id = zt.owner_id 
                                       AND zt.language = :lang";
        $connection    = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':trid' => $id, ':lang' => $language])->queryAll();
    }
}