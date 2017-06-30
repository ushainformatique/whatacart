<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\manufacturer\dto;

/**
 * ManufacturerListViewDTO class file
 * 
 * @package common\modules\manufacturer\dto
 */
class ManufacturerListViewDTO extends \frontend\dto\ListViewDTO
{
    /**
     * @var array 
     */
    private $_manList;
    
    /**
     * @var array 
     */
    private $_manufacturer;
    
    public function getManList()
    {
        return $this->_manList;
    }

    public function setManList($manList)
    {
        $this->_manList = $manList;
    }
    
    public function getManufacturer()
    {
        return $this->_manufacturer;
    }

    public function setManufacturer($manufacturer)
    {
        $this->_manufacturer = $manufacturer;
    }
}
