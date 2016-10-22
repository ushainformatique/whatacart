<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\orderstatus\managers;

use usni\library\components\UiDataManager;
use common\modules\localization\modules\orderstatus\models\OrderStatus;
use usni\UsniAdaptor;
use common\modules\order\models\Order;
/**
 * Loads default data related to order status.
 * 
 * @package common\modules\localization\modules\orderstatus\managers
 */
class OrderStatusDataManager extends UiDataManager
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
    public static function getDefaultDataSet()
    {
        return [
                    [
                        'name'                  => UsniAdaptor::t('orderstatus', Order::STATUS_CANCELLED),
                    ],
                    [
                        'name'                  => UsniAdaptor::t('orderstatus', Order::STATUS_CANCELLED_REVERSAL),
                    ],
                    [
                        'name'                  => UsniAdaptor::t('orderstatus', Order::STATUS_CHARGEBACK),
                    ],
                    [
                        'name'                  => UsniAdaptor::t('orderstatus', Order::STATUS_COMPLETED),
                    ],
                    [
                        'name'                  => UsniAdaptor::t('orderstatus', Order::STATUS_DENIED),
                    ],
                    [
                        'name'                  => UsniAdaptor::t('orderstatus', Order::STATUS_EXPIRED),
                    ],
                    [
                        'name'                  => UsniAdaptor::t('orderstatus', Order::STATUS_FAILED),
                    ],
                    [
                        'name'                  => UsniAdaptor::t('orderstatus', Order::STATUS_PENDING),
                    ],
                    [
                        'name'                  => UsniAdaptor::t('orderstatus', Order::STATUS_PROCESSED),
                    ],
                    [
                        'name'                  => UsniAdaptor::t('orderstatus', Order::STATUS_PROCESSING),
                    ],
                    [
                        'name'                  => UsniAdaptor::t('orderstatus', Order::STATUS_REFUNDED),
                    ],
                    [
                        'name'                  => UsniAdaptor::t('orderstatus', Order::STATUS_REVERSED),
                    ],
                    [
                        'name'                  => UsniAdaptor::t('orderstatus', Order::STATUS_SHIPPED),
                    ],
                    [
                        'name'                  => UsniAdaptor::t('orderstatus', Order::STATUS_VOIDED),
                    ],
                    
               ];
    }
    
    /**
     * @inheritdoc
     */
    public static function getDefaultDemoDataSet()
    {
        return [];
    }
}