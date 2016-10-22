<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace customer\utils;

use usni\library\utils\PermissionUtil;
use usni\UsniAdaptor;
use customer\models\Customer;
/**
 * CustomerPermissionUtil class file.
 * 
 * @package customer\utils
 */
class CustomerPermissionUtil extends PermissionUtil
{
    /**
     * @inheritdoc
     */
    public static function getDefaultPermissions()
    {
        $permissions = parent::getDefaultPermissions();
        if (($key = array_search('updateother', $permissions)) !== false) 
        {
            unset($permissions[$key]);
        }
        $permissions[] = 'change-password';
        return $permissions;
    }
    
    /**
     * Gets models associated to the customer module.
     * @return array
     */
    public static function getModels()
    {
        return [
                    Customer::className()
               ];
    }

    /**
     * @inheritdoc
     */
    public static function getModuleId()
    {
        return 'customer';
    }
    
    /**
     * @inheritdoc
     */
    public static function getPermissionAlias($modelClassName, $permission)
    {
        if($permission == 'change-password')
        {
            return UsniAdaptor::t('users', 'Change Password');
        }
        elseif($permission == 'change-status')
        {
            return UsniAdaptor::t('users', 'Change Status');
        }
        else
        {
            return parent::getPermissionAlias($modelClassName, $permission);
        }
    }
    
    /**
     * @inheritdoc
     */
    public static function doesUserHavePermissionToPerformAction($model, $user, $permission)
    {
        if($model['id'] != $user->id)
        {
            if($model['created_by'] == $user->id)
            {
                return true;
}
            return AuthManager::checkAccess($user, $permission);
        }
        return true;
    }
}
?>