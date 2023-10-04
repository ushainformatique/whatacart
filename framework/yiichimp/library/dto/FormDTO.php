<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\dto;

use yii\base\Model;
/**
 * FormDTO class file
 * 
 * @package usni\library\dto
 */
class FormDTO extends BaseDTO
{
    /**
     * @var array 
     */
    private $_postData;
    /**
     * @var boolean 
     */
    private $_isTransactionSuccess;
    /**
     * @var int 
     */
    private $_id;
    /**
     * @var Model 
     */
    private $_model;
    
    /**
     * @var string 
     */
    private $_scenario;
    
    /**
     * List of models for browse
     * @var array 
     */
    private $_browseModels = [];
    
    public function getPostData()
    {
        return $this->_postData;
    }
    
    public function getIsTransactionSuccess()
    {
        return $this->_isTransactionSuccess;
    }
    
    public function getId()
    {
        return $this->_id;
    }
    
    public function setPostData($postData)
    {
        $this->_postData = $postData;
    }
    
    public function setIsTransactionSuccess($isTransactionSuccess)
    {
        $this->_isTransactionSuccess = $isTransactionSuccess;
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
    
    public function getScenario()
    {
        return $this->_scenario;
    }

    public function setScenario($scenario)
    {
        $this->_scenario = $scenario;
    }
    
    public function getBrowseModels()
    {
        return $this->_browseModels;
    }

    public function setBrowseModels($browseModels)
    {
        $this->_browseModels = $browseModels;
    }
}