<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\localization\modules\country\dao;

use yii\caching\DbDependency;
use usni\UsniAdaptor;
/**
 * CountryDAO class file.
 *
 * @package common\modules\localization\modules\country\dao
 */
class CountryDAO
{
    /**
     * Get all countries.
     * @param string $language
     * @return array
     */
    public static function getAll($language)
    {
        $table      = UsniAdaptor::tablePrefix() . 'country';
        $trTable    = UsniAdaptor::tablePrefix() . 'country_translated';
        $dependency = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $table"]);
        $sql        = "SELECT pa.*, pat.name FROM $table pa, $trTable pat "
                    . "WHERE pa.id = pat.owner_id AND pat.language = :lang";
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
        $table      = UsniAdaptor::tablePrefix() . 'country';
        $trTable    = UsniAdaptor::tablePrefix() . 'country_translated';
        $sql        = "SELECT c.*, ct.name,ct.address_format FROM $table c, $trTable ct "
                    . "WHERE c.id = :id AND ct.owner_id = c.id AND ct.language = :lang";
        return UsniAdaptor::app()->db->createCommand($sql, [':id' => $id, ':lang' => $language])->queryOne();
    }
}
