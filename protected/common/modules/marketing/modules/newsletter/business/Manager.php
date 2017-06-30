<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license http://www.gnu.org/licenses/gpl.html
 */
namespace newsletter\business;

use common\modules\stores\dao\StoreDAO;
use usni\library\utils\ArrayUtil;
use newsletter\models\Newsletter;
use common\modules\marketing\services\NotificationService;
use newsletter\events\SendNewsletterEvent;
use usni\UsniAdaptor;
use newsletter\dao\NewsletterDAO;
use yii\base\InvalidParamException;
use newsletter\utils\NewsletterUtil;
use newsletter\models\NewsletterCustomers;
/**
 * Manager class file
 * 
 * @package newsletter\business
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
     * inheritdoc
     */
    public function processEdit($formDTO)
    {
        parent::processEdit($formDTO);
        $formDTO->setStoreDropdownData(ArrayUtil::map(StoreDAO::getAll($this->language), 'id', 'name'));
    }
    
    /**
     * Process send.
     * @param array $getData
     * @return boolean
     */
    public function processSend($getData)
    {
        $selectedIds  = explode(',', $getData);
        foreach ($selectedIds as $id)
        {
            $model = Newsletter::findOne($id);
            $this->sendNewsletter($model);
        }
    }
    
    /**
     * Send newsletter.
     * @param Newsletter $model
     * @return boolean
     */
    protected function sendNewsletter($model)
    {
        $storeOwner = StoreDAO::getOwner($model->store_id);
        //Notifications for all all newsletter subscribers.
        if($model->to == Newsletter::ALL_SUBSCRIBERS)
        {
            $toAddressArray = $this->getNewsletterNotificationEmails(Newsletter::ALL_SUBSCRIBERS);
            $this->processNewsletterNotifications($storeOwner, $toAddressArray, $model);
        }
        //Notification for all customers except guest.
        if($model->to == Newsletter::ALL_CUSTOMERS)
        {
            $toAddressArray = $this->getNewsletterNotificationEmails(Newsletter::ALL_CUSTOMERS);
            $this->processNewsletterNotifications($storeOwner, $toAddressArray, $model);
        }
        return true;
    }
    
    /**
     * Get newsletter notification emails.
     * @param int $to
     * @param array $groupIdArray
     * @param array $customerIdArray
     * @param array $productIdArray
     * @return array
     */
    public static function getNewsletterNotificationEmails($to, $groupIdArray = [], $customerIdArray = [], $productIdArray = [])
    {
        $newsletterCustomersTable   = UsniAdaptor::tablePrefix() . 'newsletter_customers';
        $connection                 = UsniAdaptor::app()->getDb();
        if($to == Newsletter::ALL_SUBSCRIBERS)
        {
            $sql                        = "SELECT nct.email 
                                           FROM $newsletterCustomersTable nct";
            $records    = $connection->createCommand($sql)->queryAll();
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
        if($to == Newsletter::ALL_CUSTOMERS)
        {
            $sql                        = "SELECT nct.email 
                                           FROM $newsletterCustomersTable nct WHERE nct.customer_id != :cid";
            $records    = $connection->createCommand($sql, [':cid' => 0])->queryAll();
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
     * Process newsletter notification.
     * @param array $storeOwner
     * @param array $toAddressArray
     * @param Newsletter $model
     * @return type
     */
    public function processNewsletterNotifications($storeOwner, $toAddressArray, $model)
    {
        if(!empty($toAddressArray))
        {
            foreach ($toAddressArray  as  $toAddress)
            {
                $event = new SendNewsletterEvent(['model' => $model, 'toAddress' => $toAddress, 'storeOwner' => $storeOwner]);
                $this->trigger(Newsletter::EVENT_SENDNEWSLETTER, $event);
            }
        }
    }
    
    /**
     * inheritdoc
     */
    public function loadModel($modelClass, $id)
    {
        $model  = NewsletterDAO::getById($id, $this->language);
        if ($model === null)
        {
            throw new InvalidParamException("Id is not valid: $id");
        }
        $store              = StoreDAO::getById($model['store_id'], $this->language);
        $model['storeName'] = $store['name'];
        $model['to']        = $this->getToNewsletter($model['to']);
        return $model;
    }
    
    /**
     * Get to newsletter
     * @return string
     */
    protected function getToNewsletter($to)
    {
        $toNewsletters = NewsletterUtil::getToNewsletterDropdown();
        return $toNewsletters[$to];
    }
    
    /**
     * Process unsubscribe newsletter 
     * @param type $email
     */
    public function processUnsubscribeNewsletter($email)
    {
        NewsletterCustomers::deleteAll('email = :email', [':email' => $email]);
    }
}
