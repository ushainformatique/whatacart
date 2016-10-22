<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\managers;

use common\modules\order\utils\OrderUtil;
/**
 * Base class for admin payment manager.
 * 
 * @package common\modules\payment\managers
 */
abstract class BaseAdminPaymentManager extends BasePaymentManager
{
    /**
     * @inheritdoc
     */
    public function processPurchase()
    {
        parent::processPurchase();
        $shouldSendNotification = OrderUtil::shouldSendNotification($this->order);
        $attributes = [
                        'order_id' => $this->order['id'], 
                        'status'   => $this->order['status'],
                        'comment'  => $this->checkoutDetails->confirmOrderEditForm->comments,
                        'notify_customer' => $shouldSendNotification
                      ];
        OrderUtil::addOrderHistory($this->order, $attributes);
        return true;
    }
    
    /**
     * @inheritdoc
     */
    public function updateOrderStatus()
    {
        $this->order->status  = $this->checkoutDetails->confirmOrderEditForm->status;
    }
}