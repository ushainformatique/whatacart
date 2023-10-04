<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\settings\dto;

/**
 * FormDTO class file
 * 
 * @package usni\library\modules\settings\dto
 */
class FormDTO extends \usni\library\dto\FormDTO
{
    /**
     * @var boolean 
     */
    private $_testEmailSent;
    
    /**
     * @var boolean
     */
    private  $_emptyTestEmailAddress;
    
    function getTestEmailSent()
    {
        return $this->_testEmailSent;
    }

    function setTestEmailSent($testEmailSent)
    {
        $this->_testEmailSent = $testEmailSent;
    }

    function getEmptyTestEmailAddress()
    {
        return $this->_emptyTestEmailAddress;
    }

    function setEmptyTestEmailAddress($emptyTestEmailAddress)
    {
        $this->_emptyTestEmailAddress = $emptyTestEmailAddress;
    }
}
