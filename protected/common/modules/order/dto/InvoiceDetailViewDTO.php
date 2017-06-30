<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\order\dto;

/**
 * InvoiceDetailViewDTO for invoice detail view
 *
 * @package common\modules\order\dto
 */
class InvoiceDetailViewDTO extends \usni\library\dto\DetailViewDTO
{
    /**
     * @var array 
     */
    private $_orderProducts;
    
    /**
     * @var integer 
     */
    private $_orderId;
    
    public function getOrderProducts()
    {
        return $this->_orderProducts;
    }

    public function setOrderProducts($orderProducts)
    {
        $this->_orderProducts = $orderProducts;
    }
    
    public function getOrderId()
    {
        return $this->_orderId;
    }

    public function setOrderId($orderId)
    {
        $this->_orderId = $orderId;
    }
}