<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\business\cashondelivery;

use usni\UsniAdaptor;
/**
 * Cash on delivery payment processor.
 *
 * @package common\modules\payment\business\cashondelivery
 */
class PaymentProcessor extends \common\modules\payment\business\BaseSitePaymentProcessor
{   
    /**
     * @inheritdoc
     */
    public function updateOrderStatus()
    {
        $orderStatus            = UsniAdaptor::app()->storeManager->getStoreValueByKey('order_status', 'cashondelivery', 'payment');
        if($orderStatus == null)
        {
            $defaultOrderStatus     = UsniAdaptor::app()->storeManager->getSettingValue('order_status');
            $this->order->status    = $defaultOrderStatus;
        }
        else
        {
            $this->order->status    = $orderStatus;
        }
    }
}