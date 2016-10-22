<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\managers;

use usni\library\components\UiDataManager;
use usni\UsniAdaptor;
use common\modules\payment\managers\paypal_standard\PaypalDataManager;
use common\modules\stores\utils\StoreUtil;
use common\modules\localization\modules\orderstatus\utils\OrderStatusUtil;
use common\modules\order\models\Order;
use common\modules\stores\managers\StoresDataManager;
use common\modules\extension\models\Extension;
use usni\library\utils\ArrayUtil;
/**
 * Loads default data related to payment.
 *
 * @package common\modules\payment\managers
 */
class PaymentDataManager extends UiDataManager
{   
    /**
     * @inheritdoc
     */
    public static function loadDefaultData()
    {
        static::loadDefaultDependentData();
        $installedData  = static::getUnserializedData('installdefaultdata.bin');
        $isDataLoaded   = static::checkIfClassDataLoaded($installedData);
        if($isDataLoaded)
        {
            return false;
        }
        $paymentsFile   = UsniAdaptor::getAlias('@common/modules/payment/managers/payments.php');
        $paymentMethods = require $paymentsFile;
        foreach($paymentMethods as $code => $data)
        {
            $insertData = ArrayUtil::merge($data, ['code' => $code, 'category' => 'payment']);
            $extension = new Extension(['scenario' => 'create']);
            $extension->setAttributes($insertData);
            $extension->save();
        }
        PaypalDataManager::loadDefaultData();
        $currentStore       = StoreUtil::getDefault('en-US');
        $pendingStatusId    = OrderStatusUtil::getStatusId(Order::STATUS_PENDING);
        StoreUtil::insertStoreConfiguration('cashondelivery', 'payment', 'order_status', $pendingStatusId, $currentStore->id);
        static::writeFileInCaseOfOverRiddenMethod('installdefaultdata.bin');
        return true;
    }
    
    /**
     * @inheritdoc
     */
    protected static function loadDefaultDependentData()
    {
        StoresDataManager::loadDefaultData();
    }
    
    /**
     * @inheritdoc
     */
    public static function loadDemoData()
    {
        return;
    }
    
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return null;
    }
}