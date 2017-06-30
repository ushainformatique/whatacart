<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\dto;

use usni\library\dto\FormDTO;
use common\modules\payment\models\paypal_standard\PaypalSetting;
use common\modules\payment\models\paypal_standard\PaypalOrderStatus;
/**
 * PaypalStandardFormDTO class file
 * 
 * @package common\modules\payment\dto
 */
class PaypalStandardFormDTO extends FormDTO
{
    /**
     * @var PaypalSetting
     */
    private $_paypalSettings;
    
    /**
     * @var PaypalOrderStatus 
     */
    private $_paypalOrderStatus;
    
    /**
     * @var array 
     */
    private $_transactionType;
    
    /**
     * @var array 
     */
    private $_orderStatusDropdownData;
    
    public function getPaypalSettings()
    {
        return $this->_paypalSettings;
    }

    public function getPaypalOrderStatus()
    {
        return $this->_paypalOrderStatus;
    }

    public function setPaypalSettings($paypalSettings)
    {
        $this->_paypalSettings = $paypalSettings;
    }

    public function setPaypalOrderStatus($paypalOrderStatus)
    {
        $this->_paypalOrderStatus = $paypalOrderStatus;
    }
    
    public function getOrderStatusDropdownData()
    {
        return $this->_orderStatusDropdownData;
    }

    public function setOrderStatusDropdownData($orderStatusDropdownData)
    {
        $this->_orderStatusDropdownData = $orderStatusDropdownData;
    }
    
    public function getTransactionType()
    {
        return $this->_transactionType;
    }

    public function setTransactionType($transactionType)
    {
        $this->_transactionType = $transactionType;
    }
}