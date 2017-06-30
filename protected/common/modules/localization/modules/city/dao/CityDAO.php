<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\localization\modules\city\dao;

use usni\UsniAdaptor;
use yii\caching\DbDependency;
/**
 * CityDAO class file.
 *
 * @package common\modules\localization\modules\city\dao
 */
class CityDAO extends \yii\base\Component
{
    /**
     * Get city based on id.
     * @param integer $id
     * @param string $language
     * @return array|boolean
     */
    public static function getById($id, $language)
    {
        $cityTable      = UsniAdaptor::tablePrefix(). 'city';
        $trCityTable    = UsniAdaptor::tablePrefix(). 'city_translated';
        $trCountryTable = UsniAdaptor::tablePrefix() . 'country_translated';
        $dependency     = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $cityTable"]);
        $sql            = "SELECT c.*, ct.name, cnt.name AS country_name
                           FROM $cityTable c, $trCityTable ct, $trCountryTable cnt
                           WHERE c.id = :id AND ct.owner_id = c.id AND ct.language = :clang AND c.country_id = cnt.owner_id AND cnt.language = :cnlang";
        $connection     = UsniAdaptor::app()->getDb();
        $params         = [':id' => $id, ':clang' => $language, ':cnlang' => $language];
        return $connection->createCommand($sql, $params)->cache(0, $dependency)->queryOne();
    }
    
    /**
     * Get all cities.
     * @param string $language
     * @return array|boolean
     */
    public static function getAll($language)
    {
        $cityTable      = UsniAdaptor::tablePrefix(). 'city';
        $trCityTable    = UsniAdaptor::tablePrefix(). 'city_translated';
        $trCountryTable = UsniAdaptor::tablePrefix() . 'country_translated';
        $dependency     = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $cityTable"]);
        $sql            = "SELECT c.*, ct.name, cnt.name AS country_name
                           FROM $cityTable c, $trCityTable ct, $trCountryTable cnt
                           WHERE c.id = ct.owner_id AND ct.language = :clang AND c.country_id = cnt.owner_id AND cnt.language = :cnlang";
        $connection     = UsniAdaptor::app()->getDb();
        $params         = [':clang' => $language, ':cnlang' => $language];
        return $connection->createCommand($sql, $params)->cache(0, $dependency)->queryAll();
    }
}