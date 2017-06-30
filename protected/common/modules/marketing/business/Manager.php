<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license http://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\marketing\business;

use common\modules\marketing\dto\FormDTO;
use common\modules\marketing\models\SendMailForm;
use common\modules\stores\dao\StoreDAO;
use usni\library\utils\ArrayUtil;
use customer\dao\CustomerDAO;
use products\dao\ProductDAO;
use usni\UsniAdaptor;
use customer\models\Customer;
use common\modules\marketing\services\NotificationService;
use common\modules\marketing\events\SendMailEvent;
use customer\business\Manager as CustomerBusinessManager;
use usni\library\modules\users\models\Address;
/**
 * Manager class file.
 * 
 * @package common\modules\marketing\business
 */
class Manager extends \usni\library\business\Manager
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ['notifyService' => NotificationService::className()];
    }
    
    /**
     * Process create.
     * @param FormDTO $formDTO
     */
    public function processCreate($formDTO)
    {
        $model      = new SendMailForm(['scenario' => 'send']);
        $postData   = $formDTO->getPostData();
        if(isset($postData))
        {
            $model->attributes = $postData;
            if($model->validate())
            {
                $this->processSendMail($model);
                $model = new SendMailForm(['scenario' => 'send']);
                $formDTO->setIsTransactionSuccess(true);
            }
        }
        $formDTO->setModel($model);
        $groups = CustomerBusinessManager::getInstance()->getGroups();
        $formDTO->setCustomerGroupDropdownData($groups);
        $formDTO->setCustomerDropdownData(ArrayUtil::map(CustomerDAO::getAll(), 'id', 'username'));
        $formDTO->setStoreDropdownData(ArrayUtil::map(StoreDAO::getAll($this->language), 'id', 'name'));
        $formDTO->setProductDropdownData(ArrayUtil::map(ProductDAO::getAll($this->language), 'id', 'name'));
    }
    
    /**
     * Process send mail.
     * @param Model $model
     * @return boolean
     */
    protected function processSendMail($model)
    {
        $storeOwner = StoreDAO::getOwner($model->store_id);
        //Notifications for all customers.
        if($model->to == SendMailForm::ALL_CUSTOMERS)
        {
            $toAddressArray = $this->getNotificationEmails(SendMailForm::ALL_CUSTOMERS);
            $this->processSendMailNotifications($storeOwner, $toAddressArray, $model);
        }
        //Notifications for Selected customer group.
        if($model->to == SendMailForm::CUSTOMER_GROUP)
        {
            $toAddressArray = $this->getNotificationEmails(SendMailForm::CUSTOMER_GROUP, $model->group_id);
            $this->processSendMailNotifications($storeOwner, $toAddressArray, $model);
        }
        //Notifications for selected customers.
        if($model->to == SendMailForm::CUSTOMERS)
        {
            $toAddressArray       = $this->getNotificationEmails(SendMailForm::CUSTOMERS, null, $model->customer_id);
            $this->processSendMailNotifications($storeOwner, $toAddressArray, $model);
        }
        //Notifications for selected products.
        if($model->to == SendMailForm::PRODUCTS)
        {
            $toAddressArray       = $this->getNotificationEmails(SendMailForm::PRODUCTS, null, null, $model->product_id);
            $this->processSendMailNotifications($storeOwner, $toAddressArray, $model);
        }
    }
    
    /**
     * Get notification emails.
     * @param int $to
     * @param array $groupIdArray
     * @param array $customerIdArray
     * @param array $productIdArray
     * @return array
     */
    public function getNotificationEmails($to, $groupIdArray = [], $customerIdArray = [], $productIdArray = [])
    {
        $customerTable      = UsniAdaptor::tablePrefix() . 'customer';
        $personTable        = UsniAdaptor::tablePrefix() . 'person';
        $sql                    = "SELECT pt.email 
                                  FROM $customerTable tc, $personTable pt ";
        $connection             = UsniAdaptor::app()->getDb();
        if($to == SendMailForm::ALL_CUSTOMERS)
        {
            $sql .= " WHERE tc.status = :status AND tc.person_id = pt.id";
            $records = $connection->createCommand($sql, [':status' => Customer::STATUS_ACTIVE])->queryAll();
            if(!empty($records))
            {
                $data   = [];
                foreach ($records as $record)
                {
                    $data[] = implode(' ', $record);
                }
                return $data;
            }
        }
        elseif($to == SendMailForm::CUSTOMER_GROUP)
        {
            $groupMemberTable   = UsniAdaptor::tablePrefix() . 'group_member';
            $groupIds           = implode(',', $groupIdArray);
            $sql                    = "SELECT pt.email 
                                       FROM $customerTable tc, $personTable pt, $groupMemberTable gmt "
                                    . "WHERE gmt.group_id IN ($groupIds) AND gmt.member_id = tc.id AND tc.person_id = pt.id";
            $records = $connection->createCommand($sql)->queryAll();
            if(!empty($records))
            {
                $data   = [];
                foreach ($records as $record)
                {
                    $data[] = implode(' ', $record);
                }
                return $data;
            }
        }
        elseif($to == SendMailForm::CUSTOMERS)
        {
            $customerIds    = implode(',', $customerIdArray);
            $sql           .= " WHERE tc.id IN ($customerIds) AND tc.person_id = pt.id";
            $records = $connection->createCommand($sql)->queryAll();
            if(!empty($records))
            {
                $data   = [];
                foreach ($records as $record)
                {
                    $data[] = implode(' ', $record);
                }
                return $data;
            }
        }
        elseif($to == SendMailForm::PRODUCTS)
        {
            $productIds         = implode(',', $productIdArray);
            $orderProductTable  = UsniAdaptor::tablePrefix() . 'order_product';
            $orderAddressTable  = UsniAdaptor::tablePrefix() . 'order_address_details';
            $sql    = "SELECT DISTINCT oadt.email
                       FROM $orderProductTable opt, $orderAddressTable oadt
                       WHERE opt.product_id IN ($productIds) AND opt.order_id = oadt.order_id AND oadt.type = :type";
            $records = $connection->createCommand($sql, [':type' => Address::TYPE_BILLING_ADDRESS])->queryAll();
            if(!empty($records))
            {
                $data   = [];
                foreach ($records as $record)
                {
                    $data[] = implode(' ', $record);
                }
                return $data;
            }
        }
    }
    
    /**
     * Process send mail noification.
     * @param array $storeOwner
     * @param array $toAddressArray
     * @param Newsletter $model
     * @return type
     */
    public function processSendMailNotifications($storeOwner, $toAddressArray, $model)
    {
        if(!empty($toAddressArray))
        {
            foreach ($toAddressArray  as  $toAddress)
            {
                $event = new SendMailEvent(['model' => $model, 'toAddress' => $toAddress, 'storeOwner' => $storeOwner]);
                $this->trigger(SendMailForm::EVENT_SENDMAIL, $event);
            }
        }
    }
}
