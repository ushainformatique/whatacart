<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\traits;

use usni\UsniAdaptor;
/**
 * Implement common functionality related to search model
 * 
 * @package usni\library\models
 */
trait SearchTrait
{
    /**
     * Get logged in user
     * @return array
     */
    public function getUserId()
    {
        return UsniAdaptor::app()->user->getId();
    }
    
    /**
     * Check if user can access own records only. If user has at least one other permission assigned, this would return false. 
     * This would be used while search on the grid view.
     * 
     * @param string $permissionPrefix
     * @param array of other permissions
     * @return boolean
     */
    public function canAccessOwnedRecordsOnly($permissionPrefix, $otherPermissions = [])
    {
        return UsniAdaptor::app()->authorizationManager->canAccessOwnedRecordsOnly(UsniAdaptor::app()->user->getId(), $permissionPrefix, $otherPermissions);
    }
}