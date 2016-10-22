<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\managers;

use usni\library\components\UiDataManager;
use usni\UsniAdaptor;
use usni\library\modules\notification\utils\NotificationUtil;
use customer\models\Customer;
use common\utils\ApplicationUtil;
use common\modules\sequence\managers\SequenceDataManager;
use common\managers\AuthDataManager;
use customer\utils\CustomerUtil;
use usni\library\modules\auth\models\Group;
/**
 * CustomerDataManager class file.
 * 
 * @package customer\managers
 */
class CustomerDataManager extends UiDataManager
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
        //Save notification for customer.
        $data = [
                    [
                        'type'      => 'email',
                        'notifykey' => Customer::NOTIFY_CREATECUSTOMER,
                        'subject'   => UsniAdaptor::t('customer', 'New Customer Registration'),
                        'content'   => ApplicationUtil::getDefaultEmailTemplate('_newCustomer')
                    ]
                ];
        NotificationUtil::saveNotificationTemplate($data);
        static::writeFileInCaseOfOverRiddenMethod('installdefaultdata.bin');
        return true;
    }
    
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return Customer::className();
    }
    
    /**
     * @inheritdoc
     */
    public static function loadDemoData()
    {
        static::loadDemoDependentData();
        $installedData  = static::getUnserializedData('installdemodata.bin');
        $isDataLoaded   = static::checkIfClassDataLoaded($installedData);
        if($isDataLoaded)
        {
            return false;
        }
        $wholeSaleGroup = Group::findByName('Wholesale');
        $retailerGroup  = Group::findByName('Retailer');
        $defaultGroup   = Group::findByName('Default');
        CustomerUtil::createCustomer('wholesalecustomer', $wholeSaleGroup, 'wc123!@#');
        CustomerUtil::createCustomer('retailcustomer', $retailerGroup, 'rc123!@#');
        CustomerUtil::createCustomer('defaultcustomer', $defaultGroup, 'dc123!@#');
        return true;
    }
    
    /**
     * @inheritdoc
     */
    public static function loadDefaultDependentData()
    {
        SequenceDataManager::loadDefaultData();
        AuthDataManager::loadDefaultData();
    }
    
    /**
     * @inheritdoc
     */
    public static function loadDemoDependentData()
    {
        AuthDataManager::loadDemoData();
    }
}