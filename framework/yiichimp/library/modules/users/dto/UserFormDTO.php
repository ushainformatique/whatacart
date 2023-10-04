<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\users\dto;

use usni\library\dto\FormDTO;
/**
 * UserFormDTO class file.
 * 
 * @package usni\library\modules\users\dto
 */
class UserFormDTO extends FormDTO
{
    /*
     * @var array 
     */
    private $_groups;
    
    /*
     * @var Address 
     */
    private $_address;
    
    /*
     * @var Person 
     */
    private $_person;
    
    /**
     * @var string 
     */
    private $_modelClassName;

    public function getGroups()
    {
        return $this->_groups;
    }

    public function setGroups($groups)
    {
        $this->_groups = $groups;
    }
    
    public function getAddress()
    {
        return $this->_address;
    }

    public function getPerson()
    {
        return $this->_person;
    }

    public function setAddress($address)
    {
        $this->_address = $address;
    }

    public function setPerson($person)
    {
        $this->_person = $person;
    }
    
    public function getModelClassName()
    {
        return $this->_modelClassName;
    }

    public function setModelClassName($modelClassName)
    {
        $this->_modelClassName = $modelClassName;
    }
}