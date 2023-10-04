<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\users\dto;

use usni\library\dto\GridViewDTO;
/**
 * UserGridViewDTO for users.
 * 
 * @package usni\library\modules\users\dto
 */
class UserGridViewDTO extends GridViewDTO
{
    /**
     * List of groups for the user
     * @var array
     */
    private $_groupList;
    
    public function getGroupList()
    {
        return $this->_groupList;
    }

    public function setGroupList($groupList)
    {
        $this->_groupList = $groupList;
    }
}