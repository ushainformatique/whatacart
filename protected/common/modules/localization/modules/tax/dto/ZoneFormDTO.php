<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\dto;

/**
 * ZoneFormDTO class file.
 *
 * @package taxes\dto
 */
class ZoneFormDTO extends \usni\library\dto\FormDTO
{
    /**
     * @var array 
     */
    private $_countryDropdownData;
    
    /**
     * @var array 
     */
    private $_stateDropdownData;
    
    function getCountryDropdownData()
    {
        return $this->_countryDropdownData;
    }

    function getStateDropdownData()
    {
        return $this->_stateDropdownData;
    }

    function setCountryDropdownData($countryDropdownData)
    {
        $this->_countryDropdownData = $countryDropdownData;
    }

    function setStateDropdownData($stateDropdownData)
    {
        $this->_stateDropdownData = $stateDropdownData;
    }
}
