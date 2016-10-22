<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace taxes\utils;

use usni\UsniAdaptor;
use usni\library\utils\ArrayUtil;
use taxes\models\TaxRule;
use taxes\models\ZoneTranslated;
use common\modules\localization\modules\country\models\CountryTranslated;
use common\modules\localization\modules\state\models\StateTranslated;
use products\utils\ProductUtil;
use usni\library\utils\CacheUtil;
/**
 * TaxUtil class file.
 * 
 * @package taxes\utils
 */
class TaxUtil
{
    /**
     * Gets dropdown field select data.
     * @param string $modelClass
     * @return array
     */
    public static function getDropdownDataBasedOnModel($modelClass)
    {
        $data   = CacheUtil::get($modelClass . 'DropdownList');
        if($data === false)
        {
            $data = ArrayUtil::map($modelClass::find()->indexBy('name')->all(), 'id', 'name');
            CacheUtil::set($modelClass . 'DropdownList', $data);
        }
        return $data;
    }
    
    /**
     * Get tax type dropdown.
     * @return array
     */
    public static function getTaxTypeDropdown()
    {
        return [
                    TaxRule::TAX_TYPE_FLAT      => UsniAdaptor::t('tax', 'Flat'),
                    TaxRule::TAX_TYPE_PERCENT   => UsniAdaptor::t('tax', 'Percent')
               ];
    }
    
    /**
     * Get based on dropdown.
     * @return array
     */
    public static function getBasedOnDropdown()
    {
        return [
                    TaxRule::TAX_BASED_ON_SHIPPING  => UsniAdaptor::t('customer', 'Shipping Address'),
                    TaxRule::TAX_BASED_ON_BILLING   => UsniAdaptor::t('customer', 'Billing Address')
               ];
    }
    
    /**
     * Get based on display value.
     * @param string $basedOn
     * @return string
     */
    public static function getBasedOnDisplayValue($basedOn)
    {
        $data = self::getBasedOnDropdown();
        return $data[$basedOn];
    }
    
    /**
     * Get tax zone name.
     * @param int $taxZoneId
     * @return string
     */
    public static function getTaxZoneName($taxZoneId)
    {
        $language   = UsniAdaptor::app()->languageManager->getContentLanguage();
        $zone       = ZoneTranslated::find()->where('owner_id = :oid AND language = :lang', 
                                                   [':oid' => $taxZoneId, ':lang' => $language])->asArray()->one();
        return $zone['name'];
    }
    
    /**
     * Get zip.
     * @param Zone $zone
     * @return string
     */
    public static function getZip($zone)
    {
        if($zone->is_zip_range == false && $zone->zip != null)
        {
            return $zone->zip;
        }
        elseif($zone->is_zip_range == true)
        {
            return UsniAdaptor::t('tax', 'From Zip') . '  ' . $zone->from_zip . '  ' . UsniAdaptor::t('application', 'To Zip') . '  ' . $zone->to_zip;
        }
        return UsniAdaptor::t('application',  '(not set)');
    }
    
    /**
     * Get zone country.
     * @param Zone $zone
     * @return string
     */
    public static function getZoneCountry($zone)
    {
        if($zone->country_id == -1)
        {
            return UsniAdaptor::t('localization', 'All Countries');
        }
        $language   = UsniAdaptor::app()->languageManager->getContentLanguage();
        $country    = CountryTranslated::find()->where('owner_id = :id AND language = :lang', [':id' => $zone->country_id, ':lang' => $language])
                                               ->asArray()->one();
        return $country['name'];
    }
    
    /**
     * Get zone state.
     * @param Zone $zone
     * @return string
     */
    public static function getZoneState($zone)
    {
        if($zone->state_id ==  -1)
        {
            return UsniAdaptor::t('localization', 'All States');
        }
        $language   = UsniAdaptor::app()->languageManager->getContentLanguage();
        $state      = StateTranslated::find()->where('owner_id = :id AND language = :lang', [':id' => $zone->state_id, ':lang' => $language])
                                             ->asArray()->one();
        return $state['name'];
    }
    
    /**
     * Gets country and all country drop down data.
     * @return array
     */
    public static function getCountryAndAllCountriesDropdownData()
    {
        $data       = ArrayUtil::map(CountryTranslated::find()->asArray()->indexBy('name')->all(), 'owner_id', 'name');
        $data[-1]    = UsniAdaptor::t('localization', 'All Countries');
        return $data;
    }
    
    /**
     * Gets country and all country drop down data.
     * @return array
     */
    public static function getStateAndAllStatesDropdownData()
    {
        $data       = ArrayUtil::map(StateTranslated::find()->asArray()->indexBy('name')->all(), 'owner_id', 'name');
        $data[-1]    = UsniAdaptor::t('localization', 'All States');
        return $data;
    }
    
    /**
     * Check if product tax class is allowed to delete.
     * @param ProductTaxClass $model
     * @return boolean
     */
    public static function checkIfProductTaxClassAllowedToDelete($model)
    {
        $taxRules   = self::getTaxRuleByAttribute('product_tax_class_id', $model['id']);
        $products   = ProductUtil::getProductByAttribute('tax_class_id', $model['id']);
        if(empty($taxRules) && empty($products))
        {
            return true;
        }
        return false;
    }
    
    /**
     * Get tax rule by attribute.
     * @param string $attribute
     * @param integer $value
     * @return array.
     */
    public static function getTaxRuleByAttribute($attribute, $value)
    {
        $language               = UsniAdaptor::app()->languageManager->getContentLanguage();
        $taxRuleTable           = UsniAdaptor::tablePrefix() . 'tax_rule';
        $trTaxRuleTable         = UsniAdaptor::tablePrefix() . 'tax_rule_translated';
        $taxRuleDetailsTable    = UsniAdaptor::tablePrefix() . 'tax_rule_details';
        $sql                    = "SELECT tr.*, trt.name, trd.tax_rule_id, trd.product_tax_class_id, trd.customer_group_id, trd.tax_rate_id, trd.tax_zone_id
                                   FROM $taxRuleTable tr, $trTaxRuleTable trt, $taxRuleDetailsTable trd
                                   WHERE trd." . $attribute  . "= :ptci AND trd.tax_rule_id = tr.id AND tr.id = trt.owner_id AND trt.language = :lang";
        $connection             = UsniAdaptor::app()->getDb();
        $params                 = [':ptci' => $value, ':lang' => $language];
        $records                = $connection->createCommand($sql, $params)->queryAll();
        return $records;
    }
    
    /**
     * Get tax rate by attribute.
     * @param string $attribute
     * @param integer $value
     * @return array.
     */
    public static function getTaxRateByAttribute($attribute, $value)
    {
        $language               = UsniAdaptor::app()->languageManager->getContentLanguage();
        $taxRateTable           = UsniAdaptor::tablePrefix() . 'tax_rate';
        $trTaxRateTable         = UsniAdaptor::tablePrefix() . 'tax_rate_translated';
        $sql                    = "SELECT tr.*, trt.name
                                   FROM $taxRateTable tr, $trTaxRateTable trt
                                   WHERE tr." . $attribute  . "= :tzid AND tr.id = trt.owner_id AND trt.language = :lang";
        $connection             = UsniAdaptor::app()->getDb();
        $params                 = [':tzid' => $value, ':lang' => $language];
        $records                = $connection->createCommand($sql, $params)->queryAll();
        return $records;
    }
    
    
    /**
     * Get zone by attribute.
     * @param string $attribute
     * @param integer $value
     * @return array.
     */
    public static function getZoneByAttribute($attribute, $value)
    {
        $language            = UsniAdaptor::app()->languageManager->getContentLanguage();
        $zoneTable           = UsniAdaptor::tablePrefix() . 'zone';
        $trZoneTable         = UsniAdaptor::tablePrefix() . 'zone_translated';
        $sql                    = "SELECT z.*, zt.name
                                   FROM $zoneTable z, $trZoneTable zt
                                   WHERE z." . $attribute  . "= :sid AND z.id = zt.owner_id AND zt.language = :lang";
        $connection             = UsniAdaptor::app()->getDb();
        $params                 = [':sid' => $value, ':lang' => $language];
        $records                = $connection->createCommand($sql, $params)->queryAll();
        return $records;
    }
    
    /**
     * Check if tax rate is allowed to delete.
     * @param ProductTaxClass $model
     * @return boolean
     */
    public static function checkIfTaxRateAllowedToDelete($model)
    {
        $taxRules   = self::getTaxRuleByAttribute('tax_rate_id', $model['id']);
        if(empty($taxRules))
        {
            return true;
        }
        return false;
    }
    
    /**
     * Check if zone is allowed to delete.
     * @param Zone $model
     * @return boolean
     */
    public static function checkIfZoneAllowedToDelete($model)
    {
        $taxRate   = self::getTaxRateByAttribute('tax_zone_id', $model['id']);
        if(empty($taxRate))
        {
            return true;
        }
        return false;
    }
    
    /**
     * Get taxrate based on zone and  language.
     * @param TaxRate $taxRate
     * @param string $language
     * @return array
     */
    public static function getTaxRateBasedOnZoneAndLanguage($taxRate, $language = null)
    {
        if($language == null)
        {
            $language           = UsniAdaptor::app()->languageManager->getContentLanguage();
        }
        $taxRateTable           = UsniAdaptor::tablePrefix() . 'tax_rate';
        $trTaxRateTable         = UsniAdaptor::tablePrefix() . 'tax_rate_translated';
        $trZoneTable            = UsniAdaptor::tablePrefix() . 'zone_translated';
        $sql                    = "SELECT tr.*, trt.name, tzt.name as zone_name
                                   FROM $taxRateTable tr, $trTaxRateTable trt, $trZoneTable tzt
                                   WHERE tr.tax_zone_id = :tzid AND tr.id = trt.owner_id AND trt.name = :name AND trt.language = :lang AND 
                                   tzt.owner_id = :zoid AND tzt.language = :zlang";
        $connection             = UsniAdaptor::app()->getDb();
        $params                 = [':tzid' => $taxRate->tax_zone_id, ':lang' => $language, ':name' => $taxRate->name, 
                                   ':zoid' => $taxRate->tax_zone_id, ':zlang' => $language];
        $record                 = $connection->createCommand($sql, $params)->queryOne();
        return $record;
    }
    
    /**
     * Get zone based on name, country, state, zip and language.
     * @param Zone $zone
     * @param string $language
     * @return array
     */
    public static function getZoneBasedOnNameCountryStateZipAndLanguage($zone, $language = null)
    {
        if($language == null)
        {
            $language           = UsniAdaptor::app()->languageManager->getContentLanguage();
        }
        $zoneTable              = UsniAdaptor::tablePrefix() . 'zone';
        $trZoneTable            = UsniAdaptor::tablePrefix() . 'zone_translated';
        $trCountryTable         = UsniAdaptor::tablePrefix() . 'country_translated';
        $trStateTable           = UsniAdaptor::tablePrefix() . 'state_translated';
        $sql                    = "SELECT zt.*, tzt.name, tct.name as country_name, tst.name as state_name
                                   FROM $zoneTable zt, $trZoneTable tzt, $trCountryTable tct, $trStateTable tst
                                   WHERE zt.country_id = :cid AND zt.state_id = :sid AND zt.zip = :zip AND zt.id = tzt.owner_id AND tzt.name = :name AND tzt.language = :lang AND tct.owner_id = :coid AND tct.language = :clang AND tst.owner_id = :soid AND tst.language = :slang";
        $connection             = UsniAdaptor::app()->getDb();
        $params                 = [':cid' =>  $zone->country_id, ':sid' => $zone->state_id, ':zip' => $zone->zip, 
                                   ':name' => $zone->name, ':lang' => $language, ':coid' => $zone->country_id, ':clang' => $language, 
                                   ':soid' => $zone->state_id, ':slang' => $language];
        $record                 = $connection->createCommand($sql, $params)->queryOne();
        return $record;
    }
}
