<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license http://www.gnu.org/licenses/gpl.html
 */
namespace newsletter\dto;

/**
 * DefaultController class file
 * 
 * @package newsletter\dto
 */
class FormDTO extends \usni\library\dto\FormDTO
{
    /**
     * @var array 
     */
    private $_storeDropdownData;
    
    function getStoreDropdownData()
    {
        return $this->_storeDropdownData;
    }

    function setStoreDropdownData($storeDropdownData)
    {
        $this->_storeDropdownData = $storeDropdownData;
    }
}
