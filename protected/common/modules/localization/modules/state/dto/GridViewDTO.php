<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\localization\modules\state\dto;

/**
 * GridViewDTO class file.
 * 
 * @package common\modules\localization\modules\state\dto
 */
class GridViewDTO extends \usni\library\dto\GridViewDTO
{
    /**
     * @var array 
     */
    private $_countryDropdownData;
    
    function getCountryDropdownData()
    {
        return $this->_countryDropdownData;
    }

    function setCountryDropdownData($countryDropdownData)
    {
        $this->_countryDropdownData = $countryDropdownData;
    }
}
