<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\components;

use common\modules\payment\business\BasePaymentProcessor;
use common\modules\order\models\AdminCheckout;

/**
 * PaymentFactory class file.
 * 
 * @package common\modules\payment\components
 */
class PaymentFactory extends \yii\base\Component
{
    /**
     * Type of payment
     * @var string 
     */
    public $type;
    
    /**
     * Order associated with the payment
     * @var Order 
     */
    public $order;
    
    /**
     * Checkout details
     * @var AdminCheckout 
     */
    public $checkoutDetails;
    
    /**
     * Cart details
     * @var Cart 
     */
    public $cartDetails;
    
    /**
     * Customer id associated with checkout
     * @var int 
     */
    public $customerId;
    
    /**
     * Get instance of payment factory
     * @return BasePaymentProcessor
     */
    public function getInstance()
    {
        $className  = '\common\modules\payment\business\\' . $this->type . '\PaymentProcessor'; 
        return new $className($this->getInstanceConfig());
    }
    
    /**
     * Get instance config
     * @return type
     */
    protected function getInstanceConfig()
    {
        return [
                    'order'             => $this->order, 
                    'checkoutDetails'   => $this->checkoutDetails,
                    'cartDetails'       => $this->cartDetails,
                    'customerId'        => $this->customerId
               ];
    }
}