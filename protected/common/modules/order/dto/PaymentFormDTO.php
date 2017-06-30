<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\order\dto;

use common\modules\order\models\Order;
/**
 * Data transfer object for payment
 *
 * @package common\modules\order\dto
 */
class PaymentFormDTO extends \usni\library\dto\FormDTO
{
    /**
     * @var array 
     */
    private $_paymentMethods;
    
    /**
     * @var Order 
     */
    private $_order;
    
    
    public function getPaymentMethods()
    {
        return $this->_paymentMethods;
    }

    public function setPaymentMethods($paymentMethods)
    {
        $this->_paymentMethods = $paymentMethods;
    }
    
    public function getOrder()
    {
        return $this->_order;
    }

    public function setOrder($order)
    {
        $this->_order = $order;
    }
}
