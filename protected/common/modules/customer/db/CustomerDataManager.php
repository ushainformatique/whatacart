<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\db;

use usni\library\db\DataManager;
use usni\UsniAdaptor;
use customer\models\Customer;
use usni\library\modules\auth\models\Group;
use customer\business\Manager;
use usni\library\modules\users\models\User;
/**
 * CustomerDataManager class file.
 * 
 * @package customer\db
 */
class CustomerDataManager extends DataManager
{
    /**
     * @inheritdoc
     */
    public function loadDefaultData()
    {
        $this->saveNotificationTemplate();
        return true;
    }
    
    /**
     * inheritdoc
     */
    public function getNotificationDataSet()
    {
        $filePath = UsniAdaptor::app()->getModule('customer')->basePath . '/email/_newCustomer.php';
        return  [
                    [
                        'type'      => 'email',
                        'notifykey' => Customer::NOTIFY_CREATECUSTOMER,
                        'subject'   => UsniAdaptor::t('customer', 'New Customer Registration'),
                        'content'   => file_get_contents($filePath)
                    ]
                ];
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
    public function loadDemoData()
    {
        $manager        = new Manager(['userId' => User::SUPER_USER_ID]);
        $wholeSaleGroup = Group::find()->where('name = :name', [':name' => 'Wholesale'])->asArray()->one();
        $retailerGroup  = Group::find()->where('name = :name', [':name' => 'Retailer'])->asArray()->one();
        $defaultGroup   = Group::find()->where('name = :name', [':name' => 'General'])->asArray()->one();
        $manager->createCustomer('wholesalecustomer', $wholeSaleGroup, 'wc123!@#');
        $manager->createCustomer('retailcustomer', $retailerGroup, 'rc123!@#');
        $manager->createCustomer('defaultcustomer', $defaultGroup, 'dc123!@#');
        return true;
    }
}