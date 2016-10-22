<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace cart\models;

use usni\UsniAdaptor;
use common\modules\order\models\Order;
/**
 * Class storing the data for the checkout
 * 
 * @package cart\models
 */
class Checkout extends \yii\base\Model
{
    /**
     * Associated order during checkout
     * @var Order 
     */
    public $order;
    
    /**
     * Billing info edit form
     * @var BillingInfoEditForm 
     */
    public $billingInfoEditForm;
    
    /**
     * Delivery info edit form
     * @var DeliveryInfoEditForm 
     */
    public $deliveryInfoEditForm;
    
    /**
     * Delivery options edit form
     * @var DeliveryOptionsEditForm 
     */
    public $deliveryOptionsEditForm;
    
    /**
     * Payment method edit form
     * @var PaymentMethodEditForm 
     */
    public $paymentMethodEditForm;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->order    = new Order();
        $this->billingInfoEditForm  = new BillingInfoEditForm();
        $this->deliveryInfoEditForm = new DeliveryInfoEditForm();
        $this->deliveryOptionsEditForm = new DeliveryOptionsEditForm();
        $this->paymentMethodEditForm   = new PaymentMethodEditForm();
    }
    
    /**
     * Updates session
     * @return void
     */
    public function updateSession()
    {
        if(UsniAdaptor::app()->user->isGuest)
        {
            UsniAdaptor::app()->guest->updateSession('checkout', $this);
        }
        else
        {
            UsniAdaptor::app()->customer->updateSession('checkout', $this);
        }
    }
}