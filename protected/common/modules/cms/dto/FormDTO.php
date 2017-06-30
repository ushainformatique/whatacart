<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\cms\dto;
/**
 * FormDTO class file.
 *
 * @package common\modules\cms\dto
 */
class FormDTO extends \usni\library\dto\FormDTO
{
    /**
     * Parent dropdown options
     * @var array 
     */
    private $_parentDropdownOptions;
    
    function getParentDropdownOptions()
    {
        return $this->_parentDropdownOptions;
    }

    function setParentDropdownOptions($parentDropdownOptions)
    {
        $this->_parentDropdownOptions = $parentDropdownOptions;
    }
}
