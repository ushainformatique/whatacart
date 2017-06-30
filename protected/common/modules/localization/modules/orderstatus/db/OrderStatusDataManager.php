<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\orderstatus\db;

use usni\library\db\DataManager;
use common\modules\localization\modules\orderstatus\models\OrderStatus;
use common\modules\order\models\Order;
/**
 * Loads default data related to order status.
 * 
 * @package common\modules\localization\modules\orderstatus\db
 */
class OrderStatusDataManager extends DataManager
{   
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return OrderStatus::className();
    }

    /**
     * @inheritdoc
     */
    public function getDefaultDataSet()
    {
        return [
                    [
                        'name'                  => Order::STATUS_CANCELLED
                    ],
                    [
                        'name'                  => Order::STATUS_CANCELLED_REVERSAL
                    ],
                    [
                        'name'                  => Order::STATUS_CHARGEBACK
                    ],
                    [
                        'name'                  => Order::STATUS_COMPLETED
                    ],
                    [
                        'name'                  => Order::STATUS_DENIED
                    ],
                    [
                        'name'                  => Order::STATUS_EXPIRED
                    ],
                    [
                        'name'                  => Order::STATUS_FAILED
                    ],
                    [
                        'name'                  => Order::STATUS_PENDING
                    ],
                    [
                        'name'                  => Order::STATUS_PROCESSED
                    ],
                    [
                        'name'                  => Order::STATUS_PROCESSING
                    ],
                    [
                        'name'                  => Order::STATUS_REFUNDED
                    ],
                    [
                        'name'                  => Order::STATUS_REVERSED
                    ],
                    [
                        'name'                  => Order::STATUS_SHIPPED
                    ],
                    [
                        'name'                  => Order::STATUS_VOIDED
                    ],
                    
               ];
    }
}