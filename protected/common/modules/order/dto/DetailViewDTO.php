<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\order\dto;

/**
 * DetailViewDTO for order detail view
 *
 * @package common\modules\order\dto
 */
class DetailViewDTO extends \usni\library\dto\DetailViewDTO
{
    /**
     * @var array 
     */
    private $_statusData;
    
    /**
     * @var array 
     */
    private $_orderProducts;
    
    /**
     * @var array 
     */
    private $_historyRecords;
    
    /**
     * @var boolean 
     */
    private $_emptyOrder;
    
    /**
     * @var boolean 
     */
    private $_isValidOrder;
    
    public function getStatusData()
    {
        return $this->_statusData;
    }

    public function getOrderProducts()
    {
        return $this->_orderProducts;
    }

    public function getHistoryRecords()
    {
        return $this->_historyRecords;
    }

    public function setStatusData($statusData)
    {
        $this->_statusData = $statusData;
    }

    public function setOrderProducts($orderProducts)
    {
        $this->_orderProducts = $orderProducts;
    }

    public function setHistoryRecords($historyRecords)
    {
        $this->_historyRecords = $historyRecords;
    }
    
    function getEmptyOrder()
    {
        return $this->_emptyOrder;
    }

    function setEmptyOrder($emptyOrder)
    {
        $this->_emptyOrder = $emptyOrder;
    }
    
    public function getIsValidOrder()
    {
        return $this->_isValidOrder;
    }

    public function setIsValidOrder($isValidOrder)
    {
        $this->_isValidOrder = $isValidOrder;
    }
}
