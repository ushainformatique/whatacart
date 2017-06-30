<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\dto;

use usni\library\dataproviders\ArrayRecordDataProvider;
/**
 * AssignAttributeDTO represents data transfer object for assigning attributes
 *
 * @package products\dto
 */
class AssignAttributeDTO extends \usni\library\dto\FormDTO
{
    /**
     * @var array 
     */
    private $_attributes;
    
    /**
     * @var array 
     */
    private $_product;
    
    /**
     * @var ArrayRecordDataProvider 
     */
    private $_attributesDataProvider;
    
    public function getAttributes()
    {
        return $this->_attributes;
    }

    public function getProduct()
    {
        return $this->_product;
    }

    public function setAttributes($attributes)
    {
        $this->_attributes = $attributes;
    }

    public function setProduct($product)
    {
        $this->_product = $product;
    }
    
    public function getAttributesDataProvider()
    {
        return $this->_attributesDataProvider;
    }

    public function setAttributesDataProvider(ArrayRecordDataProvider $attributesDataProvider)
    {
        $this->_attributesDataProvider = $attributesDataProvider;
    }
}
