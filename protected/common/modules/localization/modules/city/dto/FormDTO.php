<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\localization\modules\city\dto;

/**
 * FormDTO class file.
 *
 * @package common\modules\localization\modules\city\dto
 */
class FormDTO extends \usni\library\dto\FormDTO
{
    /**
     * @var array 
     */
    private $_countryDropDown;
    
    public function getCountryDropDown()
    {
        return $this->_countryDropDown;
    }

    public function setCountryDropDown($countryDropDown)
    {
        $this->_countryDropDown = $countryDropDown;
    }
}