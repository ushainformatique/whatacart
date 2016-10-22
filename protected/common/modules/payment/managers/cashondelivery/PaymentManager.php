<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\managers\cashondelivery;

use common\modules\stores\utils\StoreUtil;
/**
 * Cash on delivery payment manager.
 *
 * @package common\modules\payment\managers\cashondelivery
 */
class PaymentManager extends \common\modules\payment\managers\BaseFrontPaymentManager
{   
    /**
     * @inheritdoc
     */
    public function updateOrderStatus()
    {
        $orderStatus            = StoreUtil::getStoreValueByKey('order_status', 'cashondelivery', 'payment');
        if($orderStatus == null)
        {
            $defaultOrderStatus     = StoreUtil::getSettingValue('order_status');
            $this->order->status    = $defaultOrderStatus;
        }
        else
        {
            $this->order->status    = $orderStatus;
        }
    }
}