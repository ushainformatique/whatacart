<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\users\dto;

use usni\library\dto\DetailViewDTO;
/**
 * UserDetailViewDTO class file.
 * 
 * @package usni\library\modules\users\dto
 */
class UserDetailViewDTO extends DetailViewDTO
{
    /*
     * @var Address 
     */
    private $_address;
    
    /*
     * @var Person 
     */
    private $_person;
    
     /**
     * @var array 
     */
    private $_userGroups;
    
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
    
    function getUserGroups()
    {
        return $this->_userGroups;
    }

    function setUserGroups($_userGroups)
    {
        $this->_userGroups = $_userGroups;
    }
}
    