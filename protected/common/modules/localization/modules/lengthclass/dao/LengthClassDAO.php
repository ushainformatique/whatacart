<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\lengthclass\dao;

use usni\UsniAdaptor;
use yii\caching\DbDependency;
/**
 * Implements data access functionality related to length class.
 *
 * @package common\modules\localization\modules\lengthclass\dao
 */
class LengthClassDAO
{
    /**
     * Get length class by id
     * @param int $id
     * @param string $language  
     * @return array
     */
    public static function getById($id, $language)
    {
        $table      = UsniAdaptor::tablePrefix() . 'length_class';
        $trTable    = UsniAdaptor::tablePrefix() . 'length_class_translated';
        $sql        = "SELECT lc.*, lct.name 
                      FROM $table lc, $trTable lct WHERE lc.id = :id AND lc.id = lct.owner_id AND lct.language = :lan";
        return UsniAdaptor::app()->db->createCommand($sql, [':id' => $id, ':lan' => $language])->queryOne();
    }
    
    /**
     * Get all length classes
     * @param string $language
     * @return array
     */
    public static function getAll($language)
    {
        $table          = UsniAdaptor::tablePrefix(). 'length_class';
        $trTable        = UsniAdaptor::tablePrefix(). 'length_class_translated';
        $dependency     = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $table"]);
        $sql            = "SELECT lc.*, lct.name 
                            FROM $table lc, $trTable lct 
                            WHERE lc.id = lct.owner_id AND lct.language = :lan";
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':lan' => $language])->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get length class by unit
     * @param string $unit
     * @param string $language  
     * @return array
     */
    public static function getByUnit($unit, $language)
    {
        $table      = UsniAdaptor::tablePrefix() . 'length_class';
        $trTable    = UsniAdaptor::tablePrefix() . 'length_class_translated';
        $sql        = "SELECT lc.*, lct.name 
                      FROM $table lc, $trTable lct WHERE lc.unit = :unit AND lc.id = lct.owner_id AND lct.language = :lan";
        return UsniAdaptor::app()->db->createCommand($sql, [':unit' => $unit, ':lan' => $language])->queryOne();
    }
}
