<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\cms\dao;

use usni\UsniAdaptor;
use yii\caching\DbDependency;
/**
 * PageDAO class file.
 *
 * @package common\modules\cms\dao
 */
class PageDAO
{
    /**
     * Get children for a parent page id
     * @param int $parentId
     * @param string $language
     * @return array
     */
    public static function getChildrens($parentId, $language)
    {
        $pageTable          = UsniAdaptor::tablePrefix() . 'page';
        $trPageTable        = UsniAdaptor::tablePrefix() . 'page_translated';
        $dependency         = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $pageTable"]);
        $sql                = "SELECT pt.*, tpt.name, tpt.alias, tpt.menuitem, tpt.content, tpt.summary, tpt.metakeywords, tpt.metadescription FROM $pageTable pt, $trPageTable tpt
                               WHERE pt.parent_id = :pid AND pt.id = tpt.owner_id AND tpt.language = :lang";
        $params             = [':pid' => $parentId, ':lang' => $language];
        return UsniAdaptor::app()->db->createCommand($sql, $params)->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get all pages.
     * @param string $language
     * @return array
     */
    public static function getAllPages($language)
    {
        $pageTable          = UsniAdaptor::tablePrefix() . 'page';
        $trPageTable        = UsniAdaptor::tablePrefix() . 'page_translated';
        $dependency         = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $pageTable"]);
        $sql                = "SELECT pt.*,  tpt.name FROM $pageTable pt, $trPageTable tpt
                               WHERE pt.id = tpt.owner_id AND tpt.language = :lang";
        $params             = [':lang' => $language];
        return UsniAdaptor::app()->db->createCommand($sql, $params)->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get page by id
     * @param integer $id
     * @param string $language
     * @return array
     */
    public static function getById($id, $language)
    {
        $connection             = UsniAdaptor::app()->getDb();
        $tableName              = $connection->tablePrefix . 'page';
        $trTableName            = $connection->tablePrefix . 'page_translated';
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $tableName WHERE id = :id", 'params' => [':id' => $id]]);
        $sql                    = "SELECT p.*, pt.name, pt.alias, pt.menuitem, pt.content, pt.summary, pt.metakeywords, pt.metadescription
                                   FROM $tableName p, $trTableName pt
                                   WHERE p.id = :id AND pt.owner_id = p.id AND pt.language = :lang";
        return $connection->createCommand($sql, [':id' => $id, ':lang' => $language])
                          ->cache(0, $dependency)->queryOne();
    }
    
    /**
     * Get parent name.
     * @param integer $id
     * @param string $language
     * @return array
     */
    public static function getParentName($parentId, $language)
    {
        $connection             = UsniAdaptor::app()->getDb();
        $tableName              = UsniAdaptor::tablePrefix() . 'page';
        $trTableName            = UsniAdaptor::tablePrefix() . 'page_translated';
        $sql                    = "SELECT pt.*
                                   FROM $tableName p, $trTableName pt
                                   WHERE p.id = :id AND pt.owner_id = p.id AND pt.language = :lang";
        $data = $connection->createCommand($sql, [':id' => $parentId, ':lang' => $language])->queryOne();
        if(!empty($data))
        {
            return $data['name'];
        }
    }
    
    /**
     * Get page by alias
     * @param string $alias
     * @param string $language
     * @return array
     */
    public static function getByAlias($alias, $language)
    {
        $tableName              = UsniAdaptor::tablePrefix() . 'page';
        $trTableName            = UsniAdaptor::tablePrefix() . 'page_translated';
        $sql                    = "SELECT p.*, pt.name, pt.alias, pt.content, pt.menuitem, pt.summary, pt.metakeywords, pt.metadescription 
                                   FROM $tableName p, $trTableName pt 
                                   WHERE pt.alias = :alias AND pt.language = :lan AND pt.owner_id = p.id";
        $connection             = UsniAdaptor::app()->getDb();
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $tableName"]);
        return $connection->createCommand($sql, [':alias' => $alias, ':lan' => $language])->cache(0, $dependency)->queryOne();
    }
}
