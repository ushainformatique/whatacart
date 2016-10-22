<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\managers;

use usni\library\components\UiDataManager;
use common\modules\order\models\Order;
use usni\UsniAdaptor;
use common\utils\ApplicationUtil;
use usni\library\modules\notification\utils\NotificationUtil;
/**
 * Loads default data related to order.
 * 
 * @package common\modules\order\managers
 */
class OrderDataManager extends UiDataManager
{
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return null;
    }
    
    /**
     * @inheritdoc
     */
    public static function loadDefaultData()
    {
        $installedData  = static::getUnserializedData('installdefaultdata.bin');
        $isDataLoaded   = static::checkIfClassDataLoaded($installedData);
        if($isDataLoaded)
        {
            return false;
        }
        //Save ,notification template.
        $data = [
                    [
                        'type'      => 'email',
                        'notifykey' => Order::NOTIFY_ORDERCOMPLETION,
                        'subject'   => UsniAdaptor::t('order', 'Order Completion'),
                        'content'   => ApplicationUtil::getDefaultEmailTemplate('_orderCompletion')
                    ],
                    [
                        'type'      => 'email',
                        'notifykey' => Order::NOTIFY_ORDERRECEIVED,
                        'subject'   => UsniAdaptor::t('order', 'Received Order'),
                        'content'   => ApplicationUtil::getDefaultEmailTemplate('_orderReceive')
                    ],
                    [
                        'type'      => 'email',
                        'notifykey' => Order::NOTIFY_ORDERUPDATE,
                        'subject'   => UsniAdaptor::t('order', 'Update Order') .  ' | {{ordernumber}}',
                        'content'   => ApplicationUtil::getDefaultEmailTemplate('_orderUpdate')
                    ]
                ];
        NotificationUtil::saveNotificationTemplate($data);
        static::writeFileInCaseOfOverRiddenMethod('installdefaultdata.bin');
        return true;
    }
    
    /**
     * @inheritdoc
     */
    public static function loadDemoData()
    {
        return;
    }
}