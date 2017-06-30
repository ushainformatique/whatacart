<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\localization\modules\stockstatus\dao;

use usni\UsniAdaptor;
use yii\caching\DbDependency;
/**
 * StockStatusDAO class file.
 *
 * @package common\modules\localization\modules\stockstatus\dao
 */
class StockStatusDAO
{
    /**
     * Get all stock status.
     * @param string $language
     * @return array
     */
    public static function getAll($language)
    {
        $table      = UsniAdaptor::tablePrefix() . 'stock_status';
        $trTable    = UsniAdaptor::tablePrefix() . 'stock_status_translated';
        $dependency = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $table"]);
        $sql        = "SELECT s.*, st.name FROM $table s, $trTable st "
                    . "WHERE s.id = st.owner_id AND st.language = :lang";
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
        $table      = UsniAdaptor::tablePrefix() . 'stock_status';
        $trTable    = UsniAdaptor::tablePrefix() . 'stock_status_translated';
        $sql        = "SELECT s.*, st.name FROM $table s, $trTable st "
                    . "WHERE s.id = :id AND st.owner_id = s.id AND st.language = :lang";
        return UsniAdaptor::app()->db->createCommand($sql, [':id' => $id, ':lang' => $language])->queryOne();
    }
}
