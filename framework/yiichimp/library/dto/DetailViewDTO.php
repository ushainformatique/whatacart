<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\dto;

use yii\db\ActiveRecord;
/**
 * DetailViewDTO class file
 * 
 * @package usni\library\dto
 */
class DetailViewDTO extends BaseDTO
{
    /**
     * @var int 
     */
    private $_id;
    
    /**
     * @var string
     */
    private $_modelClass;
    
    /**
     * @var array|ActiveRecord 
     */
    private $_model;
    
    /**
     * @var array 
     */
    private $_createdBy;
    
    /**
     * @var array 
     */
    private $_modifiedBy;
    
    /**
     * @var array containing records used for the browse dropdown
     */
    private $_browseModels;
    
    /**
     * @var bool whether to render detail view in modal window 
     */
    private $_modalDisplay;

    public function getId()
    {
        return $this->_id;
    }

    public function setId($id)
    {
        $this->_id = $id;
    }

    public function getModel()
    {
        return $this->_model;
    }

    public function setModel($model)
    {
        $this->_model = $model;
    }
    
    public function getCreatedBy()
    {
        return $this->_createdBy;
    }

    public function getModifiedBy()
    {
        return $this->_modifiedBy;
    }

    public function setCreatedBy($createdBy)
    {
        $this->_createdBy = $createdBy;
    }

    public function setModifiedBy($modifiedBy)
    {
        $this->_modifiedBy = $modifiedBy;
    }

    public function getBrowseModels()
    {
        return $this->_browseModels;
    }

    public function setBrowseModels($browseModels)
    {
        $this->_browseModels = $browseModels;
    }
    
    public function getModalDisplay()
    {
        return $this->_modalDisplay;
    }

    public function setModalDisplay($modalDisplay)
    {
        $this->_modalDisplay = $modalDisplay;
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