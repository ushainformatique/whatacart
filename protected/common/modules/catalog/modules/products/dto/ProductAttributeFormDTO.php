<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\dto;

use usni\library\dto\FormDTO;
/**
 * ProductAttributeFormDTO class file.
 * 
 * @package products\dto
 */
class ProductAttributeFormDTO extends FormDTO
{
    /**
     * @var array 
     */
    private $_attributeGroupData;
    
    function getAttributeGroupData()
    {
        return $this->_attributeGroupData;
    }

    function setAttributeGroupData($attributeGroupData)
    {
        $this->_attributeGroupData = $attributeGroupData;
    }
}
