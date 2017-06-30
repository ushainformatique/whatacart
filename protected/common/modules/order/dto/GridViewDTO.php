<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\order\dto;

/**
 * GridView data transfer object
 *
 * @package common\modules\order\dto
 */
class GridViewDTO extends \usni\library\dto\GridViewDTO
{
    /**
     * @var array 
     */
    private $_statusData;
    
    /**
     * @var array 
     */
    private $_customerFilterData;
    
    /**
     * @var array 
     */
    private $_paymentMethods;
    
    /**
     * @var array 
     */
    private $_shippingMethods;
    
    public function getStatusData()
    {
        return $this->_statusData;
    }

    public function setStatusData($statusData)
    {
        $this->_statusData = $statusData;
    }
    
    public function getCustomerFilterData()
    {
        return $this->_customerFilterData;
    }

    public function setCustomerFilterData($customerFilterData)
    {
        $this->_customerFilterData = $customerFilterData;
    }
    
    public function getPaymentMethods()
    {
        return $this->_paymentMethods;
    }

    public function getShippingMethods()
    {
        return $this->_shippingMethods;
    }

    public function setPaymentMethods($paymentMethods)
    {
        $this->_paymentMethods = $paymentMethods;
    }

    public function setShippingMethods($shippingMethods)
    {
        $this->_shippingMethods = $shippingMethods;
    }
}
