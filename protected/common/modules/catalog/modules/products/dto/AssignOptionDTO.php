<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\dto;

/**
 * AssignOptionDTO represents data transfer object for assigning options
 *
 * @package products\dto
 */
class AssignOptionDTO extends \usni\library\dto\FormDTO
{
    /**
     * @var array 
     */
    private $_options;
    
    /**
     * @var array 
     */
    private $_product;
    
    /**
     * @var array 
     */
    private $_assignedOptions;
    
    public function getOptions()
    {
        return $this->_options;
    }

    public function setOptions($options)
    {
        $this->_options = $options;
    }
    
    public function getProduct()
    {
        return $this->_product;
    }

    public function setProduct($product)
    {
        $this->_product = $product;
    }
    
    public function getAssignedOptions()
    {
        return $this->_assignedOptions;
    }

    public function setAssignedOptions($assignedOptions)
    {
        $this->_assignedOptions = $assignedOptions;
    }
}
