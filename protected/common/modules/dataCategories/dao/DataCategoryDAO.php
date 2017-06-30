<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\dataCategories\dao;

use yii\caching\DbDependency;
use usni\UsniAdaptor;
/**
 * DataCategoryDAO class file.
 *
 * @package common\modules\dataCategories\dao
 */
class DataCategoryDAO
{
    /**
     * Get all data categories.
     * @param string $language
     * @return array
     */
    public static function getAll($language)
    {
        $table      = UsniAdaptor::tablePrefix() . 'data_category';
        $trTable    = UsniAdaptor::tablePrefix() . 'data_category_translated';
        $dependency = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $table"]);
        $sql        = "SELECT dc.*, dct.name FROM $table dc, $trTable dct "
                    . "WHERE dc.id = dct.owner_id AND dct.language = :lang";
        return UsniAdaptor::app()->db->createCommand($sql, [':lang' => $language])->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get data category by id.
     * ram integer $id
     * @param string $language
     * @return array
     */
    public static function getById($id, $language)
    {
        $table      = UsniAdaptor::tablePrefix() . 'data_category';
        $trTable    = UsniAdaptor::tablePrefix() . 'data_category_translated';
        $sql        = "SELECT dc.*, dct.name, dct.description FROM $table dc, $trTable dct "
                    . "WHERE dc.id = :id AND dct.owner_id = dc.id AND dct.language = :lang";
        return UsniAdaptor::app()->db->createCommand($sql, [':id' => $id, ':lang' => $language])->queryOne();
    }
    
    /**
     * Get status.
     * ram integer $id
     * @return integer
     */
    public static function getStatus($id)
    {
        $table      = UsniAdaptor::tablePrefix() . 'data_category';
        $sql        = "SELECT dc.status FROM $table dc"
                    . " WHERE dc.id = :id";
        $record     =  UsniAdaptor::app()->db->createCommand($sql, [':id' => $id])->queryOne();
        return $record['status'];
    }
}
