<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\marketing\utils;

use common\modules\marketing\models\SendMailForm;
use usni\UsniAdaptor;
use usni\library\modules\notification\models\Notification;
use usni\library\modules\notification\utils\NotificationUtil;
use common\modules\marketing\notifications\CustomerSendMailNotification;
use customer\models\Customer;
use usni\library\modules\users\models\Address;
/**
 * MarketingUtil class file.
 * @package common\modules\marketing\utils
 */
class MarketingUtil
{   
    /**
     * Get To send mail dropdown.
     * @return array
     */
    public static function getToNewsletterDropdown()
    {
        return [
                    SendMailForm::ALL_CUSTOMERS               => UsniAdaptor::t('customer', 'All Customers'),
                    SendMailForm::CUSTOMER_GROUP              => UsniAdaptor::t('customer', 'Customer Group'),
                    SendMailForm::CUSTOMERS                   => UsniAdaptor::t('customer', 'Customers'),
                    SendMailForm::PRODUCTS                    => UsniAdaptor::t('products', 'Products Purchased'),
               ];
    }
    
    /**
     * Get send mail notification emails.
     * @param int $to
     * @param array $groupIdArray
     * @param array $customerIdArray
     * @param array $productIdArray
     * @return array
     */
    public static function getNotificationEmails($to, $groupIdArray = [], $customerIdArray = [], $productIdArray = [])
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
    public static function processSendMailNotifications($storeOwner, $toAddressArray, $model)
    {
        if(!empty($toAddressArray))
        {
            foreach ($toAddressArray  as  $toAddress)
            {
                $fromAddress        = $storeOwner['email'];
                $fromName           = $storeOwner['firstname']. ' '. $storeOwner['lastname'];
                $emailNotification  = new CustomerSendMailNotification(['model' => $model, 'toAddress' => $toAddress]);
                $mailer             = UsniAdaptor::app()->mailer;
                $mailer->emailNotification = $emailNotification;
                $message            = $mailer->compose();
                $isSent             = $message->setFrom([$fromAddress => $fromName])
                                    ->setTo($toAddress)
                                    ->setSubject($model['subject'])
                                    ->send();
                $status             = $isSent === true ? Notification::STATUS_SENT : Notification::STATUS_PENDING;
                $data               = serialize(array(
                                    'fromName'    => $fromName,
                                    'fromAddress' => $fromAddress,
                                    'toAddress'   => $toAddress,
                                    'subject'     => $model['subject'],
                                    'body'        => $message->toString()));

                //Save notification
                NotificationUtil::saveEmailNotification($emailNotification, $status, $data);
            }
        }
    }
}
?>