<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\managers;

use common\modules\order\utils\OrderUtil;
/**
 * Base class for front payment manager.
 * 
 * @package common\modules\payment\managers
 */
abstract class BaseFrontPaymentManager extends BasePaymentManager
{
    /**
     * Performs confirm order
     * @return boolean
     */
    public function processConfirm()
    {
        $attributes = [
                        'order_id' => $this->order['id'], 
                        'status'   => $this->order['status'],
                        'comment'  => null,
                        'notify_customer' => true
                      ];
        OrderUtil::addOrderHistory($this->order, $attributes);
        return true;
    }
}