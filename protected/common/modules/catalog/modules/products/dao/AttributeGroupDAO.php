<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\dao;

use usni\UsniAdaptor;
use yii\caching\DbDependency;
/**
 * Implements data access functionality related to product attribute group.
 *
 * @package products\dao
 */
class AttributeGroupDAO
{
    /**
     * Get all attribute groups.
     * @param string $language
     * @return array
     */
    public static function getAll($language)
    {
        $table      = UsniAdaptor::tablePrefix() . 'product_attribute_group';
        $trTable    = UsniAdaptor::tablePrefix() . 'product_attribute_group_translated';
        $dependency = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $table"]);
        $sql        = "SELECT ag.*, agt.name FROM $table ag, $trTable agt "
                    . "WHERE ag.id = agt.owner_id AND agt.language = :lang";
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
        $table      = UsniAdaptor::tablePrefix() . 'product_attribute_group';
        $trTable    = UsniAdaptor::tablePrefix() . 'product_attribute_group_translated';
        $sql        = "SELECT ag.*, agt.name FROM $table ag, $trTable agt "
                    . "WHERE ag.id = :id AND agt.owner_id = ag.id AND agt.language = :lang";
        return UsniAdaptor::app()->db->createCommand($sql, [':id' => $id, ':lang' => $language])->queryOne();
    }
}
