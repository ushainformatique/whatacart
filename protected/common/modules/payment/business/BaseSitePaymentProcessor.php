<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\business;

use customer\models\Customer;
use usni\UsniAdaptor;
use common\modules\order\models\Order;
use common\modules\order\events\OrderEvent;
use common\modules\order\dao\OrderDAO;
use common\modules\order\services\NotificationService;
use customer\business\Manager as CustomerManager;
/**
 * Base class for front payment processor.
 * 
 * @package common\modules\payment\business
 */
abstract class BaseSitePaymentProcessor extends BasePaymentProcessor
{
    use \common\modules\localization\modules\orderstatus\traits\OrderStatusTrait;


    /**
     * inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->on(self::EVENT_ON_ORDER_CONFIRM, [$this, 'handleAfterOrderConfirmation']);
    }
    
    /**
     * inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return array_merge($behaviors, [
            NotificationService::className()
        ]);
    }
    
    /**
     * Performs confirm order
     * @return boolean
     */
    public function processConfirm()
    {
        $this->order->addHistory(UsniAdaptor::t('order', 'New Order Created'), true);
        $completedStatus = $this->getStatusId(Order::STATUS_COMPLETED, $this->language);
        //Receive complete order details in a single query for email
        $order           = OrderDAO::getById($this->order['id'], $this->language, $this->selectedStoreId);
        if($this->order->status != $completedStatus)
        {
            $this->trigger(Order::EVENT_NEW_ORDER_CREATED, new OrderEvent(['order' => $order]));
        }
        else
        {
            $this->trigger(Order::EVENT_ORDER_COMPLETED, new OrderEvent(['order' => $order]));
        }
        $this->trigger(self::EVENT_ON_ORDER_CONFIRM, new OrderEvent(['order' => $order]));
        return true;
    }
    
    /**
     * @inheritdoc
     */
    protected function addCustomerActivity($key)
    {
        //Add customer activity.
        $loggedInCustomerId = UsniAdaptor::app()->user->getId();
        if($loggedInCustomerId != null)
        {
            $customerModel  = Customer::findOne($loggedInCustomerId);
            $activityData   = ['customer_id' => $loggedInCustomerId, 'name' => $customerModel->getName(), 'order_id' =>  $this->order['id']];
            CustomerManager::getInstance()->addActivity($key, $activityData);
        }
        else
        {
            $checkout       = $this->checkoutDetails;
            $name           = $checkout['billingInfoEditForm']['firstname'] . ' ' . $checkout['billingInfoEditForm']['lastname'];
            $activityData   = ['customer_id' => Customer::GUEST_CUSTOMER_ID, 'name' => $name, 'order_id' => $this->order['id']];
            CustomerManager::getInstance()->addActivity($key . '_guest', $activityData);
        }
    }
    
    /**
     * Handle after order confirmation
     * @param OrderEvent $event
     */
    public function handleAfterOrderConfirmation(OrderEvent $event)
    {
        $this->addCustomerActivity('add_address');
        $this->addCustomerActivity('account_order_created');
    }
}