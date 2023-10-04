<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\dto;

/**
 * BulkEditFormDTO class file
 * 
 * @package usni\library\dto
 */
class BulkEditFormDTO extends FormDTO
{
    /**
     * @var string 
     */
    private $_modelClass;
    
    /**
     * @var array
     */
    private $_selectedIds;
    
    public function getSelectedIds()
    {
        return $this->_selectedIds;
    }

    public function setSelectedIds($selectedIds)
    {
        $this->_selectedIds = $selectedIds;
    }
    
    public function getModelClass()
    {
        return $this->_modelClass;
    }

    public function setModelClass($modelClass)
    {
        $this->_modelClass = $modelClass;
    }
}
