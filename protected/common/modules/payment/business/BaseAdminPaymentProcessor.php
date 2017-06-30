<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\business;

use usni\UsniAdaptor;
use usni\fontawesome\FA;
use usni\library\utils\Html;
use common\modules\order\models\Order;
use common\modules\order\services\NotificationService;
use common\modules\order\events\OrderEvent;
use common\modules\order\business\Manager as OrderBusinessManager;
use common\modules\order\dao\OrderDAO;
/**
 * Base class for admin payment processor.
 * 
 * @package common\modules\payment\business
 */
abstract class BaseAdminPaymentProcessor extends BasePaymentProcessor
{   
    use \common\modules\localization\modules\orderstatus\traits\OrderStatusTrait;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        //Set the currency set in customer form
        $this->selectedCurrency  = $this->checkoutDetails->customerForm->currencyCode;
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
        //Update latest order status
        $this->order->status    = $this->checkoutDetails->confirmOrderEditForm->status;
        $this->order->save();
        $shouldSendNotification = $this->shouldSendNotification();
        $this->order->addHistory($this->checkoutDetails->confirmOrderEditForm->comments, $shouldSendNotification);
        $completedStatus        = $this->getStatusId(Order::STATUS_COMPLETED, $this->language);
        //Receive complete order details in a single query for email
        $order                      = OrderDAO::getById($this->order['id'], $this->language, $this->selectedStoreId);
        $order['currency_symbol']   = UsniAdaptor::app()->currencyManager->getCurrencySymbol($order['currency_code']);
        if($this->order->status != $completedStatus)
        {
            $this->trigger(Order::EVENT_NEW_ORDER_CREATED, new OrderEvent(['order' => $order]));
        }
        else
        {
            $this->trigger(Order::EVENT_ORDER_COMPLETED, new OrderEvent(['order' => $order]));
        }
        return true;
    }
    
    /**
     * Get captured amount
     * @return float
     */
    public function getCapturedAmount()
    {
        return OrderBusinessManager::getInstance()->getAlreadyPaidAmountForOrder($this->order['id']);
    }
    
    /**
     * Get payment activity url
     * @param array $model
     * @return atring
     */
    public function getPaymentActivityUrl($model)
    {
        $label = UsniAdaptor::t('order', 'Add Payment');
        $icon  = FA::icon('plus-circle'). "\n";
        $url   = UsniAdaptor::createUrl("order/payment/add", ['orderId' => $model['id']]);
        return Html::a($icon, $url, [
                                            'title' => $label
                                      ]);
    }
    
    /**
     * Check if this method can be used where a payment could be made using multiple payment methods for example cashondelivery, cheque etc.
     * @return boolean
     */
    public function isAllowedForMultipleModePayment()
    {
        return true;
    }
}