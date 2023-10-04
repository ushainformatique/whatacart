<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\auth\dto;

/**
 * Data transfer object for group form.
 *
 * @package usni\library\modules\auth\dto
 */
class FormDTO extends \usni\library\dto\FormDTO
{
    /**
     * Parent dropdown options
     * @var array 
     */
    private $_parentDropdownOptions;
    
    /**
     * Group member options
     * @var array 
     */
    private $_groupMemberOptions;
    
    public function getParentDropdownOptions()
    {
        return $this->_parentDropdownOptions;
    }

    public function setParentDropdownOptions($parentDropdownOptions)
    {
        $this->_parentDropdownOptions = $parentDropdownOptions;
    }
    
    public function getGroupMemberOptions()
    {
        return $this->_groupMemberOptions;
    }

    public function setGroupMemberOptions($groupMemberOptions)
    {
        $this->_groupMemberOptions = $groupMemberOptions;
    }
}
