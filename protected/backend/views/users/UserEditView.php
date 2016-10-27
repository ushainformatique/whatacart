<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace backend\views\users;

use usni\library\modules\auth\models\Group;
use usni\UsniAdaptor;
use customer\utils\CustomerUtil;
use usni\library\utils\ArrayUtil;
/**
 * UserEditView class file.
 * 
 * @package backend\views\users
 */
class UserEditView extends \usni\library\modules\users\views\UserEditView
{
    /**
     * @inheritdoc
     */
    public function getUserGroups()
    {
        $groups  = parent::getUserGroups();
        $customerGroupsData = CustomerUtil::getCustomerGroupDropdownData();
        $customerGroup      = CustomerUtil::getCustomerGroupByName(CustomerUtil::getDefaultGroupTitle());
        $customerGroupsData = ArrayUtil::merge([$customerGroup['id'] => $customerGroup['name']], $customerGroupsData);
        foreach($groups as $key => $value)
        {
            if(array_key_exists($key, $customerGroupsData))
            {
                unset($groups[$key]);
            }
        }
        return $groups;
    }
}