<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace productCategories\dto;

/**
 * ProductCategoryListViewDTO class file
 * 
 * @package productCategories\dto
 */
class ProductCategoryListViewDTO extends \frontend\dto\ListViewDTO
{
    /**
     * @var array 
     */
    private $_categoryList;
    
    /**
     * @var array 
     */
    private $_productCategory;
    
    public function getCategoryList()
    {
        return $this->_categoryList;
    }

    public function getProductCategory()
    {
        return $this->_productCategory;
    }

    public function setCategoryList($categoryList)
    {
        $this->_categoryList = $categoryList;
    }

    public function setProductCategory($productCategory)
    {
        $this->_productCategory = $productCategory;
    }
}
