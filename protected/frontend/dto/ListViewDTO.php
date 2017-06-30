<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\dto;

use usni\library\dataproviders\ArrayRecordDataProvider;
use frontend\models\SearchForm;
/**
 * ListViewDTO class file.
 * 
 * @package frontend\dto
 */
class ListViewDTO extends \usni\library\dto\BaseDTO
{
    /**
     * @var integer 
     */
    private $_id;
    
    /**
     * @var SearchForm 
     */
    private $_searchModel;
    
    /**
     * @var ArrayRecordDataProvider
     */
    private $_dataprovider;
    
    /**
     * @var array 
     */
    private $_sortingOption;
    
    /**
     * @var integer 
     */
    private $_pageSize;
    
    /**
     * @var int 
     */
    private $_dataCategoryId;
    
    public function getId()
    {
        return $this->_id;
    }

    public function getSearchModel()
    {
        return $this->_searchModel;
    }

    public function getDataprovider()
    {
        return $this->_dataprovider;
    }

    public function getSortingOption()
    {
        return $this->_sortingOption;
    }

    public function getPageSize()
    {
        return $this->_pageSize;
    }

    public function getDataCategoryId()
    {
        return $this->_dataCategoryId;
    }

    public function setId($id)
    {
        $this->_id = $id;
    }

    public function setSearchModel(SearchForm $searchModel)
    {
        $this->_searchModel = $searchModel;
    }

    public function setDataprovider(ArrayRecordDataProvider $dataprovider)
    {
        $this->_dataprovider = $dataprovider;
    }

    public function setSortingOption($sortingOption)
    {
        $this->_sortingOption = $sortingOption;
    }

    public function setPageSize($pageSize)
    {
        $this->_pageSize = $pageSize;
    }

    public function setDataCategoryId($dataCategoryId)
    {
        $this->_dataCategoryId = $dataCategoryId;
    }
}
