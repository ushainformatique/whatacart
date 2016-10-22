<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\managers\paypal_standard;

use usni\library\components\UiDataManager;
use common\modules\localization\modules\orderstatus\managers\OrderStatusDataManager;
use common\modules\payment\utils\paypal_standard\PaypalUtil;
use common\modules\stores\utils\StoreUtil;
use common\modules\stores\managers\StoresDataManager;
/**
 * PaypalDataManager class file.
 * 
 * @package common\modules\payment\managers\paypal_standard
 */
class PaypalDataManager extends UiDataManager
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
        $paypalToOrderStatusMap = PaypalUtil::getPaypalToOrderStatusMap();
        $currentStore           = StoreUtil::getDefault('en-US');
        StoreUtil::batchInsertStoreConfiguration($paypalToOrderStatusMap, $currentStore, 'paypal_standard_orderstatus_map', 'payment');
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
    
    /**
     * @inheritdoc
     */
    protected static function loadDefaultDependentData()
    {
        OrderStatusDataManager::loadDefaultData();
        StoresDataManager::loadDefaultData();
    }
    
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return null;
    }
}