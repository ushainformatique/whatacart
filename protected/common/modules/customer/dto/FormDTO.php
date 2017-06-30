<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\dto;

use usni\library\modules\users\dto\UserFormDTO;
/**
 * FormDTO class file.
 * 
 * @package customer\dto
 */
class FormDTO extends UserFormDTO
{   
    /**
     * @var boolean 
     */
    private $_activationStatusIssue;
    
    /**
     * @var boolean 
     */
    private $_notRegisteredEmailId;
    
    function getActivationStatusIssue()
    {
        return $this->_activationStatusIssue;
    }

    function getNotRegisteredEmailId()
    {
        return $this->_notRegisteredEmailId;
    }

    function setActivationStatusIssue($activationStatusIssue)
    {
        $this->_activationStatusIssue = $activationStatusIssue;
    }

    function setNotRegisteredEmailId($notRegisteredEmailId)
    {
        $this->_notRegisteredEmailId = $notRegisteredEmailId;
    }
}
