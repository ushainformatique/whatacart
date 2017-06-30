<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace productCategories\dto;

/**
 * FormDTO class file.
 * 
 * @package products\dto
 */
class FormDTO extends \usni\library\dto\FormDTO
{
    /**
     * Data categories array
     * @var array 
     */
    private $_dataCategories;
    
    /**
     * Parent dropdown options
     * @var array 
     */
    private $_parentDropdownOptions;
    
    function getDataCategories()
    {
        return $this->_dataCategories;
    }

    function setDataCategories($dataCategories)
    {
        $this->_dataCategories = $dataCategories;
    }
    
    public function getParentDropdownOptions()
    {
        return $this->_parentDropdownOptions;
    }

    public function setParentDropdownOptions($parentDropdownOptions)
    {
        $this->_parentDropdownOptions = $parentDropdownOptions;
    }
}
