<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\dto;

use usni\library\dto\GridViewDTO;
/**
 * ProductReviewGridViewDTO class file.
 * 
 * @package products\dto
 */
class ProductReviewGridViewDTO extends GridViewDTO
{
    /**
     * @var array 
     */
    private $_productDropDownData;
    
    function getProductDropDownData()
    {
        return $this->_productDropDownData;
    }

    function setProductDropDownData($productDropDownData)
    {
        $this->_productDropDownData = $productDropDownData;
    }
}
