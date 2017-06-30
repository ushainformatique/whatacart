<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\orderstatus\dao;

use usni\UsniAdaptor;
use yii\caching\DbDependency;
/**
 * Implements data access functionality related to order status.
 *
 * @package common\modules\localization\modules\orderstatus\dao
 */
class OrderStatusDAO
{
    /**
     * Get all weight classes
     * @param string $language
     * @return array
     */
    public static function getAll($language)
    {
        $table          = UsniAdaptor::tablePrefix(). 'order_status';
        $trTable        = UsniAdaptor::tablePrefix(). 'order_status_translated';
        $dependency     = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $table"]);
        $sql            = "SELECT os.*, ost.name 
                            FROM $table os, $trTable ost 
                            WHERE os.id = ost.owner_id AND ost.language = :lan";
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':lan' => $language])->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get by id.
     * @param integer $id
     * @param string $language
     * @return array
     */
    public static function getById($id, $language)
    {
        $table      = UsniAdaptor::tablePrefix() . 'order_status';
        $trTable    = UsniAdaptor::tablePrefix() . 'order_status_translated';
        $sql        = "SELECT o.*, ot.name FROM $table o, $trTable ot "
                    . "WHERE o.id = :id AND ot.owner_id = o.id AND ot.language = :lang";
        return UsniAdaptor::app()->db->createCommand($sql, [':id' => $id, ':lang' => $language])->queryOne();
    }
}