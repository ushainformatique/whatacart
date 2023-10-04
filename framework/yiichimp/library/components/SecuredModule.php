<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\components;

use usni\library\components\Module;
use usni\UsniAdaptor;
use usni\library\utils\ArrayUtil;
/**
 * Module which is secured in the application should extend this class.
 * 
 * @package usni\library\components
 */
abstract class SecuredModule extends Module
{
    /**
     * Get permissions for the module.
     * @return array
     */
    public function getPermissions()
    {
        $permissions            = [];
        $modelClassNames        = $this->getPermissionModels();
        $defaultPermissions     = $this->getDefaultPermissions();
        $excludedPermissions    = $this->getModelToExcludedPermissions();
        //Add module access permission
        $moduleName             = ucfirst($this->id);
        $moduleResource         = $moduleName . 'Module';
        //Access tab permission is there for parent module and not child modules
        if(strpos($this->uniqueId, '/') === false)
        {
            $permissions[$moduleResource]['access.' . $this->id] = UsniAdaptor::t('application', 'Access Tab');
        }
        foreach($modelClassNames as $modelClassName)
        {
            $modelExcludedPermissions = ArrayUtil::getValue($excludedPermissions, $modelClassName, []);
            foreach($defaultPermissions as $permission)
            {
                if(in_array($permission, $modelExcludedPermissions) === false)
                {
                    $alias          = $this->getPermissionAlias($modelClassName, $permission);
                    $shortModelName = UsniAdaptor::getObjectClassName($modelClassName);
                    $permission     = strtolower($shortModelName) . '.' . $permission;
                    $permissions[$shortModelName][$permission] = $alias;
                }
            }
            
        }
        return $permissions;
    }
    
    /**
     * Get the list of models on which permissions would be applied
     * @return array
     */
    public function getPermissionModels()
    {
        return [];
    }
    
    /**
     * Prepare permissions
     * @param array $config
     * @return array
     */
    public function preparePermissionsForModel($modelClassName, $inputPermissions)
    {
        $permissions = [];
        foreach($inputPermissions as $permission)
        {
            $alias          = $this->getPermissionAlias($modelClassName, $permission);
            $shortModelName = UsniAdaptor::getObjectClassName($modelClassName);
            $permission     = strtolower($shortModelName) . '.' . $permission;
            $permissions[$shortModelName][$permission] = $alias;
        }
        return $permissions;
    }
    
    /**
     * Get permission alias.
     * @param string $modelClassName
     * @param string $permission
     * @return string
     */
    public function getPermissionAlias($modelClassName, $permission)
    {
        if($permission == 'manage')
        {
            return $this->getPermissionLabels($permission) . ' ' . $modelClassName::getLabel(2);
        }
        else
        {
            return $this->getPermissionLabels($permission)  . ' ' . $modelClassName::getLabel();
        }
    }
    
    /**
     * Get permission labels.
     * @param string $permission
     * @return string
     */
    public function getPermissionLabels($permission)
    {
        switch($permission)
        {
            case 'create': return UsniAdaptor::t('application', 'Create');
            case 'update': return UsniAdaptor::t('application', 'Update');
            case 'delete': return UsniAdaptor::t('application', 'Delete');
            case 'view': return UsniAdaptor::t('application', 'View');
            case 'manage': return UsniAdaptor::t('application', 'Manage');
            case 'bulk-edit': return UsniAdaptor::t('application', 'Bulk Edit');
            case 'bulk-delete': return UsniAdaptor::t('application', 'Bulk Delete');
            case 'updateother': return UsniAdaptor::t('application', 'Update Others');
            case 'viewother': return UsniAdaptor::t('application', 'View Others');
            case 'deleteother': return UsniAdaptor::t('application', 'Delete Others');
            default: return null;
        }
    }
    
    /**
     * Get default permissions.
     * @return array
     */
    public function getDefaultPermissions()
    {
        return [
                    'create',
                    'view',
                    'viewother',
                    'update',
                    'updateother',
                    'delete',
                    'deleteother',
                    'manage',
                    'bulk-edit',
                    'bulk-delete'
               ];
    }
    
    /**
     * Get model to excluded permissions.
     * @return array
     */
    public function getModelToExcludedPermissions()
    {
         return array();
    }
}