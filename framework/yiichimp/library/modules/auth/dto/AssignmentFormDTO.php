<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\auth\dto;

/**
 * Data transfer object for assignment form.
 *
 * @package usni\library\modules\auth\dto
 */
class AssignmentFormDTO extends \usni\library\dto\FormDTO
{
    /**
     * Identity dropdown options
     * @var array 
     */
    private $_identityDropdownOptions;
    
    /**
     * Containing map of module id to permission count mapping
     * @var array 
     */
    private $_modulesPermissionCountMap;
    
    /**
     * Containing module to assignment count map for the identity
     * @var array 
     */
    private $_identityModuleAssignmentMap;
    
    public function getIdentityDropdownOptions()
    {
        return $this->_identityDropdownOptions;
    }

    public function setIdentityDropdownOptions($identityDropdownOptions)
    {
        $this->_identityDropdownOptions = $identityDropdownOptions;
    }
    
    public function getModulesPermissionCountMap()
    {
        return $this->_modulesPermissionCountMap;
    }

    public function setModulesPermissionCountMap($modulesPermissionCountMap)
    {
        $this->_modulesPermissionCountMap = $modulesPermissionCountMap;
    }
    
    public function getIdentityModuleAssignmentMap()
    {
        return $this->_identityModuleAssignmentMap;
    }

    public function setIdentityModuleAssignmentMap($identityModuleAssignmentMap)
    {
        $this->_identityModuleAssignmentMap = $identityModuleAssignmentMap;
    }
}
