<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\dto;

use usni\library\dataproviders\ArrayRecordDataProvider;
/**
 * Data transfer object for product
 *
 * @package products\dto
 */
class FormDTO extends \usni\library\dto\FormDTO
{
    /**
     * @var array 
     */
    private $_taxClasses;
    
    /**
     * @var array 
     */
    private $_lengthClasses;
    
    /**
     * @var array 
     */
    private $_weightClasses;
    
    /**
     * @var array 
     */
    private $_manufacturers;
    
    /**
     * @var array 
     */
    private $_categories;
    
    /**
     * @var array 
     */
    private $_relatedProducts;
    
    /**
     * @var array 
     */
    private $_groups;
    
    /**
     * @var array 
     */
    private $_discounts;
    
    /**
     * @var array 
     */
    private $_specials;
    
    /**
     * @var array 
     */
    private $_images;
    
    /**
     * @var array 
     */
    private $_assignedOptions;
    
    /**
     * @var ArrayRecordDataProvider 
     */
    private $_attributesDataProvider;
    
    /**
     * @var array 
     */
    private $_downloads;


    public function getTaxClasses()
    {
        return $this->_taxClasses;
    }

    public function setTaxClasses($taxClasses)
    {
        $this->_taxClasses = $taxClasses;
    }
    
    public function getLengthClasses()
    {
        return $this->_lengthClasses;
    }

    public function getWeightClasses()
    {
        return $this->_weightClasses;
    }

    public function setLengthClasses($lengthClasses)
    {
        $this->_lengthClasses = $lengthClasses;
    }

    public function setWeightClasses($weightClasses)
    {
        $this->_weightClasses = $weightClasses;
    }
    
    public function getManufacturers()
    {
        return $this->_manufacturers;
    }

    public function getCategories()
    {
        return $this->_categories;
    }

    public function getRelatedProducts()
    {
        return $this->_relatedProducts;
    }

    public function setManufacturers($manufacturers)
    {
        $this->_manufacturers = $manufacturers;
    }

    public function setCategories($categories)
    {
        $this->_categories = $categories;
    }

    public function setRelatedProducts($relatedProducts)
    {
        $this->_relatedProducts = $relatedProducts;
    }
    
    public function getGroups()
    {
        return $this->_groups;
    }

    public function getDiscounts()
    {
        return $this->_discounts;
    }

    public function setGroups($groups)
    {
        $this->_groups = $groups;
    }

    public function setDiscounts($discounts)
    {
        $this->_discounts = $discounts;
    }
    
    public function getSpecials()
    {
        return $this->_specials;
    }

    public function setSpecials($specials)
    {
        $this->_specials = $specials;
    }
    
    public function getImages()
    {
        return $this->_images;
    }

    public function setImages($images)
    {
        $this->_images = $images;
    }
    
    public function getAssignedOptions()
    {
        return $this->_assignedOptions;
    }

    public function setAssignedOptions($assignedOptions)
    {
        $this->_assignedOptions = $assignedOptions;
    }
    
    public function getAttributesDataProvider()
    {
        return $this->_attributesDataProvider;
    }

    public function setAttributesDataProvider(ArrayRecordDataProvider $attributesDataProvider)
    {
        $this->_attributesDataProvider = $attributesDataProvider;
    }
    
    public function getDownloads()
    {
        return $this->_downloads;
    }

    public function setDownloads($downloads)
    {
        $this->_downloads = $downloads;
    }
}
