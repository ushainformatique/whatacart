<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */ 
namespace common\modules\order\models;

use yii\base\Model;
use usni\UsniAdaptor;
use common\modules\order\models\CustomerForm;
use cart\models\BillingInfoEditForm;
use cart\models\DeliveryInfoEditForm;
use cart\models\DeliveryOptionsEditForm;
use cart\models\PaymentMethodEditForm;
use common\modules\order\models\AdminConfirmOrderEditForm;
use common\modules\order\models\OrderProductForm;
use customer\models\Customer;
/**
 * AdminCheckout class file. This is same as checkout model in front. It stores
 * the order information related to a customer in the admin panel.
 *
 * @package common\modules\order\models
 */
class AdminCheckout extends Model
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
     * Confirm order edit form
     * @var ConfirmOrderEditForm 
     */
    public $confirmOrderEditForm;
    
    /**
     * Order Customer Form
     * @var CustomerForm 
     */
    public $customerForm;
    
    /**
     * Order Product
     * @var Model 
     */
    public $orderProductForm;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->order    = new Order();
        $this->customerForm    = new CustomerForm();
        $this->billingInfoEditForm  = new BillingInfoEditForm();
        $this->deliveryInfoEditForm = new DeliveryInfoEditForm();
        $this->deliveryOptionsEditForm = new DeliveryOptionsEditForm();
        $this->paymentMethodEditForm   = new PaymentMethodEditForm();
        $this->confirmOrderEditForm    = new AdminConfirmOrderEditForm();
        $this->orderProductForm        = new OrderProductForm();
    }

    /**
     * Updates session
     * @return void
     */
    public function updateSession()
    {
        if(UsniAdaptor::app()->customer->customerId == Customer::GUEST_CUSTOMER_ID)
        {
            UsniAdaptor::app()->customer->updateSession('checkout', $this);
        }
        else
        {
            UsniAdaptor::app()->customer->updateSession('checkout', $this);
        }
    }
}