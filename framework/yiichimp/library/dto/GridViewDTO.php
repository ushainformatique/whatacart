<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\dto;

use yii\db\ActiveRecord;
/**
 * GridViewDTO class file
 * 
 * @package usni\library\dto
 */
class GridViewDTO extends BaseDTO
{
    /**
     * @var array 
     */
    private $_queryParams;
    
    /**
     * @var ActiveRecord 
     */
    private $_searchModel;
    
    /**
     * @var instance of \yii\data\BaseDataProvider
     */
    private $_dataProvider;
    
    /**
     * @var string 
     */
    private $_modelClass;
    
    /**
     * This would be used in case of bulk delete
     * @var array
     */
    private $_selectedIdsForBulkDelete;
    
    public function getSearchModel()
    {
        return $this->_searchModel;
    }
    
    public function getDataProvider()
    {
        return $this->_dataProvider;
    }
    
    public function setSearchModel($searchModel)
    {
        $this->_searchModel = $searchModel;
    }
    
    public function setDataProvider($dataProvider)
    {
        $this->_dataProvider = $dataProvider;
    }
    
    public function getQueryParams()
    {
        return $this->_queryParams;
    }

    public function setQueryParams($queryParams)
    {
        $this->_queryParams = $queryParams;
    }
    
    public function getSelectedIdsForBulkDelete()
    {
        return $this->_selectedIdsForBulkDelete;
    }

    public function setSelectedIdsForBulkDelete($_selectedIdsForBulkDelete)
    {
        $this->_selectedIdsForBulkDelete = $_selectedIdsForBulkDelete;
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