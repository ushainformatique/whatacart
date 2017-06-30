<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\business;

use customer\models\Customer;
use usni\library\modules\auth\dao\AuthDAO;
use customer\dao\CustomerDAO;
/**
 * GroupManager class file.
 *
 * @package customer\business
 */
class GroupManager extends \usni\library\modules\auth\business\Manager
{
    /**
     * inheritdoc
     */
    public $memberType = 'customer';
    
    /**
     * inheritdoc
     */
    public $modelClass = 'usni\library\modules\auth\models\Group';


    /**
     * inheritdoc
     */
    protected function getModelClassNames()
    {
        return [Customer::className()];
    }
    
    /**
     * inheritdoc
     */
    public function getBrowseModels($modelClass)
    {
        return AuthDAO::getAllGroupsByCategory('customer');
    }
    
    /**
     * Get list of members.
     * 
     * @param string $groupId
     * return string
     */
    public function getMembersList($groupId)
    {
        $membersId     = [];
        $membersName   = [];
        $groupMembers  = AuthDAO::getMembers($groupId);
        foreach($groupMembers as $groupMember)
        {
            $membersId[] = $groupMember['member_id'];
        }

        foreach($membersId as $id)
        {
            $member         = CustomerDAO::getById($id);
            $membersName[]  = $member['username'];
        }
        return implode(', ', $membersName);
    }
    
    /**
     * inheritdoc
     */
    public function getPermissionPrefix($modelClass)
    {
        return 'group';
    }
}