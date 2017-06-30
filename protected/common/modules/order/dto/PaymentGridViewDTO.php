<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\order\dto;

/**
 * GridView data transfer object for payment grid view
 *
 * @package common\modules\order\dto
 */
class PaymentGridViewDTO extends \usni\library\dto\GridViewDTO
{
    /**
     * @var array 
     */
    private $_paymentMethods;
    
    public function getPaymentMethods()
    {
        return $this->_paymentMethods;
    }

    public function setPaymentMethods($paymentMethods)
    {
        $this->_paymentMethods = $paymentMethods;
    }
}
