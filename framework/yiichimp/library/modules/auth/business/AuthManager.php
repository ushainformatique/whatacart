<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\auth\business;

use usni\UsniAdaptor;
use usni\library\modules\users\models\User;
use usni\library\modules\auth\models\Group;
use usni\library\modules\auth\models\AuthAssignment;
use usni\library\modules\auth\models\AuthPermission;
use usni\library\utils\ArrayUtil;
use usni\library\components\SecuredModule;
use usni\library\exceptions\FailedToSaveModelException;
use yii\base\NotSupportedException;
use usni\library\utils\CacheUtil;
use usni\library\modules\auth\dao\AuthDAO;
use yii\rbac\CheckAccessInterface;
use usni\library\modules\users\dao\UserDAO;
/**
 * Application component that handles the functionality related to authorization in the application.
 * 
 * @package usni\library\modules\auth\components
 */
class AuthManager extends \yii\base\Component implements CheckAccessInterface
{
    /**
     * Constants for auth identity
     */
    const TYPE_GROUP = 'group';
    const TYPE_USER  = 'user';
    
    /**
     * @var array of default other permissions 
     */
    public $defaultOtherPermssions = ['updateother', 'viewother', 'deleteother'];
    
    /**
     * Adds resource permission.
     * @param string $permission
     * @param string $resource
     * @param string $moduleId
     * @param string $alias
     * @return boolean
     */
    public function addPermission($permission, $resource, $moduleId, $alias)
    {
        if($this->checkIfPermissionExist($permission, $resource) === false)
        {
            $authPermission           = new AuthPermission(['scenario' => 'create']);
            $authPermission->resource = $resource;
            $authPermission->name     = $permission;
            $authPermission->module   = $moduleId;
            $authPermission->alias    = $alias;
            if($authPermission->save())
            {
                return true;
            }
            else
            {
                throw new FailedToSaveModelException(AuthPermission::className());
            }
        }
        return true;
    }

    /**
     * Add modules permissions. This would loop through all the modules, retrieve the permissions
     * and add it to database
     * @param $useCache boolean
     * @return void
     */
    public function addModulesPermissions()
    {
        UsniAdaptor::db()->createCommand()->truncateTable(AuthPermission::tableName())->execute();
        $modules                = UsniAdaptor::app()->moduleManager->getInstantiatedModules();
        $finalPermissions       = [];
        foreach($modules as $key => $module)
        {
            if($module instanceof SecuredModule)
            {
                $modulePermissionsSet = $module->getPermissions();
                foreach($modulePermissionsSet as $resource => $permissionSet)
                {
                    foreach($permissionSet as $permission => $alias)
                    {
                        $finalPermissions[] = [$permission, $resource, $module->uniqueId, $alias, User::SUPER_USER_ID, date('Y-m-d H:i:s')];
                    }
                }
            }
        }
        $table      = UsniAdaptor::tablePrefix() . 'auth_permission';
        $columns    = ['name', 'resource', 'module', 'alias', 'created_by', 'created_datetime'];
        try
        {
            UsniAdaptor::app()->db->createCommand()->batchInsert($table, $columns, $finalPermissions)->execute();
        }
        catch (\yii\db\Exception $e)
        {
            throw $e;
        }
        return true;
    }

    /**
     * Checks if a resource permission exists.
     * @param string $permission
     * @param string $resource
     * @return void
     */
    public function checkIfPermissionExist($permission, $resource)
    {
        $query = AuthPermission::find();
        $query->where('name = :name AND resource = :resource');
        $query->params([':name' => $permission, ':resource' => $resource]);
        if($query->count() == 0)
        {
            return false;
        }
        return true;
    }

    /**
     * Add permissions for a single module.
     * @param \yii\base\Module $module
     * @return boolean
     */
    public function addModulePermissions($module)
    {
        $moduleClassName   = get_class($module);
        $permissions       = $module->getPermissions();
        foreach($permissions as $resource => $permissionSet)
        {
            foreach($permissionSet as $permission => $alias)
            {
                $this->addPermission($permission, $resource, $module->id, $alias);
            }
        }
        CacheUtil::set($moduleClassName . 'ModulePermissions', $permissions);
        return true;
    }

    /**
     * Add auth assignments for the identity.
     * @param array $permissions
     * @param int $identityName
     * @param string $identityType
     * @return void
     */
    public function addAssignments($permissions, $identityName, $identityType)
    {
        $user           = UsniAdaptor::app()->user->getIdentity();
        if($user == null)
        {
            $userId = User::SUPER_USER_ID;
        }
        else
        {
            $userId = $user->id;
        }
        $this->deleteAssignments($identityName, $identityType);
        $tableName      = UsniAdaptor::app()->db->tablePrefix. 'auth_assignment';
        $batchData      = [];
        foreach ($permissions as $permission)
        {
            $authPermission         = AuthDAO::getPermissionByName($permission);
            $data['identity_type']  = $identityType;
            $data['identity_name']  = $identityName;
            $data['permission']     = $permission;
            $data['resource']       = $authPermission['resource'];
            $data['module']         = $authPermission['module'];
            $data['created_by']     = $userId;
            $data['created_datetime']     = date('Y-m-d H:i:s');
            $batchData[]            = $data;
        }
        $columns    = ['identity_type', 'identity_name', 'permission', 'resource', 'module', 'created_by', 'created_datetime'];
        try
        {
            UsniAdaptor::app()->db->createCommand()->batchInsert($tableName, $columns, $batchData)->execute();
        }
        catch(\yii\db\Exception $e)
        {
            throw $e;
        }
    }
    
    /**
     * Get assignments by identity.
     * @param string $identityName
     * @param string $identityType
     * @return array
     */
    public function getAssignmentsByIdentity($identityName, $identityType)
    {
        return AuthAssignment::find()->where('identity_type = :aot AND identity_name = :aon', 
                                                    [':aot' => $identityType, ':aon' => $identityName])->asArray()->all();
    }

    /**
     * Get assigned permissions by identity.
     * @param string $identityName
     * @param string $identityType
     * @return array
     */
    public function getAssignedPermissions($identityName, $identityType)
    {
        $records   = $this->getAssignmentsByIdentity($identityName, $identityType);
        $assignedPermissions = [];
        foreach($records as $record)
        {
            $assignedPermissions[] = $record['permission'];
        }
        return $assignedPermissions;
    }

    /**
     * Gets auth identity object.
     * @param int $identityId
     * @param string $identityType
     * @return IAuthIdentity Model implementing IAuthIdentity interface
     * @throws NotSupportedException
     */
    public function getIdentity($identityId, $identityType)
    {
        if($identityType == 'group')
        {
            $authIdentityClassName = Group::className();
        }
        elseif($identityType == 'user')
        {
            $authIdentityClassName = User::className();
        }
        else
        {
            throw new NotSupportedException();
        }
        return $authIdentityClassName::findOne($identityId);
    }

    /**
     * Delete auth assignments.
     * @param string $identityName
     * @param string $identityType
     * @param string $resource
     * @return void
     */
    public function deleteAssignments($identityName, $identityType, $resource = null)
    {
        if($resource != null)
        {
            $condition = 'resource = :resource AND identity_type =:itype AND identity_name = :iname';
            $params    = [':resource' => $resource, ':itype' => $identityType, ':iname' => $identityName];
        }
        else
        {
            $condition = 'identity_name = :iname AND identity_type = :itype';
            $params    = [':itype'    => $identityType,
                          ':iname'    => $identityName];
        }
        AuthAssignment::deleteAll($condition, $params);
    }

    /**
     * Gets all permissions assigned to the user. This includes permissions assigned to the groups to
     * which user belongs and specific permissions assigned to the user only
     * @param User $userId
     * @return array
     */
    public function getEffectivePermissions($userId)
    {
        $effectivePermissions   = CacheUtil::get($userId . '-effectivePermissions');
        if(empty($effectivePermissions))
        {
            $permissions    = [];
            $memberRecords  = AuthDAO::getGroups($userId);
            if(!empty($memberRecords))
            {
                foreach($memberRecords as $groupId)
                {
                    $permissions = ArrayUtil::merge($permissions, $this->getPermissionsByGroup($groupId));
                }
            }
            $user                   = UserDAO::getById($userId);
            $userPermissions        = $this->getAssignedPermissions($user['username'], 'user');
            $effectivePermissions   = ArrayUtil::merge($permissions, $userPermissions);
            CacheUtil::set($userId. '-effectivePermissions', $effectivePermissions);
        }
        return $effectivePermissions;
    }

    /**
     * Process and get permissions by group.
     * @param int $groupId
     * @return array
     */
    public function getPermissionsByGroup($groupId)
    {
        $group              = Group::findOne($groupId);
        $records            = $this->getAssignedPermissions($group->name, self::TYPE_GROUP);
        $childGroups        = $group->getTreeRecordsInHierarchy();
        $childRecords       = array();
        foreach($childGroups as $childGroup)
        {
            $rows           = $this->getAssignedPermissions($childGroup['name'], AuthManager::TYPE_GROUP);
            $childRecords   = ArrayUtil::merge($childRecords, $rows);
        }
        return ArrayUtil::merge($childRecords, $records);
    }

    /**
     * Get all permissions list.
     * @return array
     */
    public function getAllPermissionsList()
    {
        $permissions    = AuthPermission::find()->orderBy(['resource' => SORT_ASC])->asArray()->all();
        $data           = CacheUtil::get('allPermissionsList');
        if($data === false)
        {
            $data =[];
            foreach($permissions as $permission)
            {
                $data[$permission['module']][$permission['resource']][$permission['name']] = $permission['alias'];
            }
            CacheUtil::set('allPermissionsList', $data);
        }
        return $data;
    }

    /**
     * Delete auth assignment by permission
     * @param string $permission
     * @param string $authType
     * @param string $authName
     * @return void
     */
    public static function deleteAssignmentsByPermission($permission, $authType, $authName)
    {
        AuthAssignment::deleteAll('identity_name = :aon AND identity_type = :aot AND permission = :pm',
                                  [':aon' => $authName, ':aot' => $authType, ':pm' => $permission]);
    }

    /**
     * Add auth assignment.
     * @param string $permission
     * @param string $authType
     * @param string $authName
     * @return void
     */
    public function addAssignment($permission, $authType, $authName)
    {
        $user                   = UsniAdaptor::app()->user->getIdentity();
        static::deleteAssignmentsByPermission($permission, $authType, $authName);
        $tableName              = UsniAdaptor::app()->db->tablePrefix. 'auth_assignment';
        $authPermission         = AuthDAO::getPermissionByName($permission);
        $data['identity_type']  = $authType;
        $data['identity_name']  = $authName;
        $data['permission']     = $permission;
        $data['resource']       = $authPermission['resource'];
        $data['module']         = $authPermission['module'];
        $data['created_by']     = $data['modified_by'] = $user->id;
        $data['created_datetime'] = $data['modified_datetime'] = date('Y-m-d H:i:s');
        UsniAdaptor::app()->db->createCommand()->insert($tableName, $data)->execute();
    }

    /**
     * Is logged in user a super user
     * @param integer $userId
     * @return boolean
     */
    public function isSuperUser($userId)
    {
        if($userId != null && $userId == User::SUPER_USER_ID)
        {
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function checkAccess($userId, $permissionName, $params = [])
    {
        if($this->isSuperUser($userId))
        {
            return true;
        }
        $permissions = $this->getEffectivePermissions($userId);
        if(in_array($permissionName, $permissions))
        {
            return true;
        }
        return false;
    }

    /**
     * Get module permission count
     * @param string $id
     * @return int
     */
    public function getModulePermissionCount($id)
    {
        $data = $this->getConsolidatedModulePermissions($id);
        return count($data);
    }
    
    /**
     * Get consolidated module permissions. The permissions are returned like 
     * [auth => AuthModule' => [], 'Group' => []] so we consolidate all the permissions
     * @param string $id
     * @return int
     */
    public function getConsolidatedModulePermissions($id)
    {
        $data           = [];
        $module         = UsniAdaptor::app()->getModule($id);
        $permissions    = $module->getPermissions();
        foreach($permissions as $resource => $set)
        {
            $data = ArrayUtil::merge($data, $set);
        }
        return $data;
    }
    
    /**
     * Check if user can access own records only. If user has at least one other 
     * permission assigned, this would return false. 
     * 
     * @param integer id of the user identity
     * @param string $permissionPrefix
     * @param array of other permissions
     * @return boolean
     */
    public function canAccessOwnedRecordsOnly($userId, $permissionPrefix, $otherPermissions = [])
    {
        if(empty($otherPermissions))
        {
            $otherPermissions = $this->defaultOtherPermssions;
        }
        foreach ($otherPermissions as $otherPermission)
        {
            if($this->checkAccess($userId, $permissionPrefix . '.' . $otherPermission))
            {
                return false;
            }
        }
        return true;
    }
}