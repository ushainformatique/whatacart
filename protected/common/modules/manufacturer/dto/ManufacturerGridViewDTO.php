<?php

/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\manufacturer\dto;

use usni\library\dto\BaseGridViewDTO;
/**
 * ManufacturerGridViewDTO class file
 * 
 * @package common\modules\manufacturer\dto
 */
class ManufacturerGridViewDTO extends BaseGridViewDTO
{
    /**
     * @var string 
     */
    private $_modelClassName;
    
    public function getModelClassName()
    {
        return $this->_modelClassName;
    }

    public function setModelClassName($modelClassName)
    {
        $this->_modelClassName = $modelClassName;
    }
}
