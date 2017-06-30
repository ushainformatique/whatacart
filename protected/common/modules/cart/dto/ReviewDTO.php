<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace cart\dto;

/**
 * Data transfer object for checkout review screen
 *
 * @package cart\dto
 */
class ReviewDTO extends \usni\library\dto\BaseDTO
{
    /**
     * @var string 
     */
    private $_billingContent;
    
    /**
     * @var string 
     */
    private $_shippingContent;
    
    /**
     * @var string 
     */
    private $_shippingName;
    
    /**
     * @var string 
     */
    private $_paymentMethodName;
    
    /**
     * @var array 
     */
    private $_allStatus;
    
    /**
     * @var string payment method form content 
     */
    private $_paymentFormContent;
    
    public function getBillingContent()
    {
        return $this->_billingContent;
    }

    public function getShippingContent()
    {
        return $this->_shippingContent;
    }

    public function getShippingName()
    {
        return $this->_shippingName;
    }

    public function getPaymentMethodName()
    {
        return $this->_paymentMethodName;
    }

    public function setBillingContent($billingContent)
    {
        $this->_billingContent = $billingContent;
    }

    public function setShippingContent($shippingContent)
    {
        $this->_shippingContent = $shippingContent;
    }

    public function setShippingName($shippingName)
    {
        $this->_shippingName = $shippingName;
    }

    public function setPaymentMethodName($paymentMethodName)
    {
        $this->_paymentMethodName = $paymentMethodName;
    }
    
    public function getAllStatus()
    {
        return $this->_allStatus;
    }

    public function setAllStatus($allStatus)
    {
        $this->_allStatus = $allStatus;
    }
    
    public function getPaymentFormContent()
    {
        return $this->_paymentFormContent;
    }

    public function setPaymentFormContent($paymentFormContent)
    {
        $this->_paymentFormContent = $paymentFormContent;
    }
}
