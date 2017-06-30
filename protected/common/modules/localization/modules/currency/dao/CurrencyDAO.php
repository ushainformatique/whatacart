<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\localization\modules\currency\dao;

use usni\UsniAdaptor;
use yii\caching\DbDependency;
use common\modules\localization\modules\currency\models\Currency;
/**
 * Manager class file.
 *
 * @package common\modules\localization\modules\currency\dao
 */
class CurrencyDAO
{
    /**
     * Get all currencies.
     * 
     * @param string $language
     * @return array
     */
    public static function getAll($language)
    {
        $table      = UsniAdaptor::tablePrefix() . 'currency';
        $trTable    = UsniAdaptor::tablePrefix() . 'currency_translated';
        $dependency = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $table"]);
        $sql        = "SELECT c.*, ct.name FROM $table c, $trTable ct "
                    . "WHERE c.status = :status AND c.id = ct.owner_id AND ct.language = :lang";
        return UsniAdaptor::app()->db->createCommand($sql, [':status' => Currency::STATUS_ACTIVE, ':lang' => $language])->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get currency list.
     * 
     * @return array
     */
    public static function getList()
    {
        $table      = UsniAdaptor::tablePrefix() . 'currency';
        $dependency = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $table"]);
        $sql        = "SELECT c.* FROM $table c "
                    . "WHERE c.status = :status";
        return UsniAdaptor::app()->db->createCommand($sql, [':status' => Currency::STATUS_ACTIVE])->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get by id.
     * @param integer $id
     * @param string $language
     * @return array
     */
    public static function getById($id, $language)
    {
        $table      = UsniAdaptor::tablePrefix() . 'currency';
        $trTable    = UsniAdaptor::tablePrefix() . 'currency_translated';
        $sql        = "SELECT c.*, ct.name FROM $table c, $trTable ct "
                    . "WHERE c.id = :id AND ct.owner_id = c.id AND ct.language = :lang";
        return UsniAdaptor::app()->db->createCommand($sql, [':id' => $id, ':lang' => $language])->queryOne();
    }
    
    /**
     * Get currency by code
     * @param string $code
     * @return array
     */
    public static function getByCode($code, $language)
    {
        $currencyTable          = UsniAdaptor::tablePrefix() . 'currency';
        $currencyTrTable        = UsniAdaptor::tablePrefix() . 'currency_translated';
        $sql                    = "SELECT c.*, ctr.name 
                                   FROM $currencyTable c, $currencyTrTable ctr 
                                   WHERE c.code = :code AND c.id = ctr.owner_id AND ctr.language = :lan";
        $connection             = UsniAdaptor::app()->getDb();
        return  $connection->createCommand($sql, [':code' => $code ,':lan' => $language])->queryOne();
    }
}