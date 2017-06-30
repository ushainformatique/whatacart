<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license http://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\marketing\dto;

/**
 * FormDTO class file.
 * 
 * @package common\modules\marketing\dto
 */
class FormDTO extends \usni\library\dto\FormDTO
{
    /**
     * @var array 
     */
    private $_customerGroupDropdownData;
    
    /**
     * @var array 
     */
    private $_storeDropdownData;
    
    /**
     * @var array 
     */
    private $_customerDropdownData;
    
    /**
     * @var array 
     */
    private $_productDropdownData;
    
    function getCustomerGroupDropdownData()
    {
        return $this->_customerGroupDropdownData;
    }

    function setCustomerGroupDropdownData($customerGroupDropdownData)
    {
        $this->_customerGroupDropdownData = $customerGroupDropdownData;
    }
    
    function getStoreDropdownData()
    {
        return $this->_storeDropdownData;
    }

    function getCustomerDropdownData()
    {
        return $this->_customerDropdownData;
    }

    function getProductDropdownData()
    {
        return $this->_productDropdownData;
    }

    function setStoreDropdownData($storeDropdownData)
    {
        $this->_storeDropdownData = $storeDropdownData;
    }

    function setCustomerDropdownData($customerDropdownData)
    {
        $this->_customerDropdownData = $customerDropdownData;
    }

    function setProductDropdownData($productDropdownData)
    {
        $this->_productDropdownData = $productDropdownData;
    }
}
