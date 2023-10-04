<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\auth\dao;

use usni\UsniAdaptor;
use yii\caching\DbDependency;
/**
 * AuthDAO class file
 *
 * @package usni\library\modules\auth\dao
 */
class AuthDAO
{
    /**
     * Get members for a group
     * @param int $groupId
     * @return array
     */
    public static function getMembers($groupId)
    {
        $table      = UsniAdaptor::tablePrefix() . 'group_member';
        $dependency = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $table"]);
        $sql        = "SELECT * FROM $table WHERE group_id = :gid";
        return UsniAdaptor::app()->db->createCommand($sql, [':gid' => $groupId])->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Gets groups.
     * @param int $id member id
     * @param string $memberType
     * @return array
     */
    public static function getGroups($id, $memberType = 'user')
    {
        $groupTable         = UsniAdaptor::tablePrefix() . 'group';
        $groupMemberTable   = UsniAdaptor::tablePrefix() . 'group_member';
        $sql        = "SELECT tg.* FROM $groupTable tg, $groupMemberTable tgm
                      WHERE tgm.member_id = :mid AND tgm.member_type = :mt AND tgm.group_id = tg.id";
        $params     = [':mid' => $id, ':mt' => $memberType];
        $records    = UsniAdaptor::app()->db->createCommand($sql, $params)->queryAll();
        $groups     = [];
        foreach($records as $record)
        {
            $groups[$record['id']] = $record;
        }
        return $groups;
    }
    
    /**
     * Get permission by name
     * @param string $name
     * @return array
     */
    public static function getPermissionByName($name)
    {
        $tableName  = UsniAdaptor::app()->db->tablePrefix . 'auth_permission';
        $sql        = "SELECT * FROM $tableName WHERE name = :name";
        $dependency = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $tableName"]);
        return UsniAdaptor::app()->db->createCommand($sql, [':name' => $name])->cache(0, $dependency)->queryOne();
    }
    
    /**
     * Get children for a parent group id
     * @param int $parentId
     * @param string $type
     * @return array
     */
    public static function getChildrens($parentId, $type)
    {
        $groupTable         = UsniAdaptor::tablePrefix() . 'group';
        $dependency         = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $groupTable"]);
        $sql                = "SELECT * FROM $groupTable
                               WHERE parent_id = :pid AND category = :type ORDER BY path";
        $params             = [':type' => $type, ':pid' => $parentId];
        return UsniAdaptor::app()->db->createCommand($sql, $params)->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get children for a parent group id
     * @param int $id
     * @param string $path
     */
    public static function updatePath($id, $path)
    {
        $groupTable         = UsniAdaptor::tablePrefix() . 'group';
        UsniAdaptor::db()->createCommand()->update($groupTable, ['path' => $path], 'id = :id', [':id' => $id])->execute();
    }
    
    /**
     * Delete group members.
     * @param integer $id
     * @param string $memberType
     * @return void
     */
    public static function deleteGroupMembers($id, $memberType)
    {
        $tableName  = UsniAdaptor::tablePrefix() . 'group_member';
        UsniAdaptor::db()->createCommand()
                      ->delete($tableName,
                               'member_id = :mid AND member_type = :mt',
                               array(':mid' => $id, ':mt' => $memberType))->execute();
    }
    
    /**
     * Get all groups by category.
     * @param string $category
     * @return type
     */
    public static function getAllGroupsByCategory($category)
    {
        $tableName  = UsniAdaptor::tablePrefix() . 'group';
        $sql                = "SELECT * FROM $tableName
                               WHERE category = :type";
        $params             = [':type' => $category];
        return UsniAdaptor::app()->db->createCommand($sql, $params)->queryAll(); 
    }
}