<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\currency\utils;

use usni\library\utils\ArrayUtil;
use common\modules\localization\modules\currency\models\Currency;
use common\modules\localization\modules\currency\models\CurrencyTranslated;
use yii\caching\DbDependency;
use usni\UsniAdaptor;
use usni\library\utils\CacheUtil;
use common\modules\order\utils\OrderUtil;
/**
 * CurrencyUtil class file
 *
 * @package common\modules\localization\modules\currency\utils
 */
class CurrencyUtil
{   
    /**
     * Gets dropdown field select data.
     * @param string $key
     * @return array
     */
    public static function getDropdownByKey($key)
    {
        $data = ArrayUtil::map(Currency::find()->indexBy('name')->all(), $key, 'name');
        return $data;
    }
    
    /**
     * Get page by alias
     * @param string $alias
     * @param string $language
     * @return array
     */
    public static function getAllCurrencies($language = null)
    {
        if($language == null)
        {
            $language           = UsniAdaptor::app()->languageManager->getDisplayLanguage();
        }
        $currencyTable          = Currency::tableName();
        $currencyTrTable        = CurrencyTranslated::tableName();
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $currencyTable"]);
        $sql                    = "SELECT c.*, ctr.name 
                                        FROM $currencyTable c, $currencyTrTable ctr 
                                        WHERE c.id = ctr.owner_id AND ctr.language = :lan";
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':lan' => $language])->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get currency name.
     * @param string $currencyCode
     * @return array
     */
    public static function getCurrencyName($currencyCode)
    {
        $record                 = CacheUtil::get($currencyCode . '-currency');
        if($record === false)
        {
            $language               = UsniAdaptor::app()->languageManager->getDisplayLanguage();
            $currencyTable          = UsniAdaptor::tablePrefix() . 'currency';
            $currencyTrTable        = UsniAdaptor::tablePrefix() . 'currency_translated';
            $sql                    = "SELECT ctr.name 
                                            FROM $currencyTable c, $currencyTrTable ctr 
                                            WHERE c.code = :code AND c.id = ctr.owner_id AND ctr.language = :lan";
            $connection             = UsniAdaptor::app()->getDb();
            $record                 =  $connection->createCommand($sql, [':code' => $currencyCode ,':lan' => $language])->queryOne();
            CacheUtil::set($currencyCode . '-currency', $record);
        }
        return $record;
    }
    
    /**
     * Check if allowed to delete
     * @param Currency $model
     * @return boolean
     */
    public static function checkIfAllowedToDelete($model)
    {
        //Check the orders associated
        $orders = OrderUtil::getOrdersByAttribute('currency_code', $model['code']);
        if($model['value'] != 1.00 && empty($orders))
        {
            return true;
        }
        return false;
    }
    
    /**
     * Get currency by code
     * @param string $code
     * @return array
     */
    public static function getCurrencyByCode($code)
    {
        $language               = UsniAdaptor::app()->languageManager->getDisplayLanguage();
        $currencyTable          = UsniAdaptor::tablePrefix() . 'currency';
        $currencyTrTable        = UsniAdaptor::tablePrefix() . 'currency_translated';
        $sql                    = "SELECT c.* 
                                        FROM $currencyTable c, $currencyTrTable ctr 
                                        WHERE c.code = :code AND c.id = ctr.owner_id AND ctr.language = :lan";
        $connection             = UsniAdaptor::app()->getDb();
        return  $connection->createCommand($sql, [':code' => $code ,':lan' => $language])->queryOne();
    }
}