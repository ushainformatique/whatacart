<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\shipping\dto;

use usni\library\dto\FormDTO;
/**
 * FlatShippingFormDTO class file
 * 
 * @package common\modules\shipping\dto
 */
class FlatShippingFormDTO extends FormDTO
{
    /**
     * @var array 
     */
    private $_zoneDropdownData;
    
    function getZoneDropdownData()
    {
        return $this->_zoneDropdownData;
    }

    function setZoneDropdownData($zoneDropdownData)
    {
        $this->_zoneDropdownData = $zoneDropdownData;
    }
}
