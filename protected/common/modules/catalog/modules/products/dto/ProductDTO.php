<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\dto;

use usni\library\dataproviders\ArrayRecordDataProvider;
/**
 * Product Data Transfer Object class file
 * 
 * @package products\dto
 */
class ProductDTO extends \usni\library\dto\BaseDTO
{
    /**
     * @var int 
     */
    private $_id;
    
    /**
     * @var array 
     */
    private $_product;
    
    /**
     * @var ArrayRecordDataProvider 
     */
    private $_reviewListDataProvider;
    
    /**
     * @var array 
     */
    private $_groupedAttributes;
    
    /**
     * @var array 
     */
    private $_tags;
    
    /**
     * @var array 
     */
    private $_assignedOptions;
    
    /**
     * @var array 
     */
    private $_relatedProducts;
    
    public function getId()
    {
        return $this->_id;
    }

    public function setId($id)
    {
        $this->_id = $id;
    }

    public function getProduct()
    {
        return $this->_product;
    }

    public function setProduct($product)
    {
        $this->_product = $product;
    }
    
    public function getReviewListDataProvider()
    {
        return $this->_reviewListDataProvider;
    }

    public function setReviewListDataProvider(ArrayRecordDataProvider $reviewListDataProvider)
    {
        $this->_reviewListDataProvider = $reviewListDataProvider;
    }
    
    public function getGroupedAttributes()
    {
        return $this->_groupedAttributes;
    }

    public function setGroupedAttributes($groupedAttributes)
    {
        $this->_groupedAttributes = $groupedAttributes;
    }
    
    public function getAssignedOptions()
    {
        return $this->_assignedOptions;
    }

    public function setAssignedOptions($assignedOptions)
    {
        $this->_assignedOptions = $assignedOptions;
    }
    
    public function getTags()
    {
        return $this->_tags;
    }

    public function setTags($tags)
    {
        $this->_tags = $tags;
    }
    
    public function getRelatedProducts()
    {
        return $this->_relatedProducts;
    }

    public function setRelatedProducts($relatedProducts)
    {
        $this->_relatedProducts = $relatedProducts;
    }
}
