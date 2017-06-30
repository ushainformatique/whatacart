<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\weightclass\dao;

use usni\UsniAdaptor;
use yii\caching\DbDependency;
/**
 * Implements data access functionality related to weight class.
 *
 * @package common\modules\localization\modules\weightclass\dao
 */
class WeightClassDAO
{
    /**
     * Get weight class by id
     * @param int $id
     * @param string $language  
     * @return array
     */
    public static function getById($id, $language)
    {
        $table      = UsniAdaptor::tablePrefix() . 'weight_class';
        $trTable    = UsniAdaptor::tablePrefix() . 'weight_class_translated';
        $sql        = "SELECT wc.*, wct.name 
                      FROM $table wc, $trTable wct WHERE wc.id = :id AND wc.id = wct.owner_id AND wct.language = :lan";
        return UsniAdaptor::app()->db->createCommand($sql, [':id' => $id, ':lan' => $language])->queryOne();
    }
    
    /**
     * Get all weight classes
     * @param string $language
     * @return array
     */
    public static function getAll($language)
    {
        $table          = UsniAdaptor::tablePrefix(). 'weight_class';
        $trTable        = UsniAdaptor::tablePrefix(). 'weight_class_translated';
        $dependency     = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $table"]);
        $sql            = "SELECT wc.*, wct.name 
                            FROM $table wc, $trTable wct 
                            WHERE wc.id = wct.owner_id AND wct.language = :lan";
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':lan' => $language])->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get weight class by unit
     * @param string $unit
     * @param string $language  
     * @return array
     */
    public static function getByUnit($unit, $language)
    {
        $table      = UsniAdaptor::tablePrefix() . 'weight_class';
        $trTable    = UsniAdaptor::tablePrefix() . 'weight_class_translated';
        $sql        = "SELECT wc.*, wct.name 
                      FROM $table wc, $trTable wct WHERE wc.unit = :unit AND wc.id = wct.owner_id AND wct.language = :lan";
        return UsniAdaptor::app()->db->createCommand($sql, [':unit' => $unit, ':lan' => $language])->queryOne();
    }
}
