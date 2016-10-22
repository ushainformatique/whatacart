<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace newsletter\utils;

use newsletter\notifications\CustomerNewsletterNotification;
use usni\library\modules\notification\utils\NotificationUtil;
use newsletter\models\Newsletter;
use usni\UsniAdaptor;
use usni\library\modules\notification\models\Notification;
/**
 * NewsletterUtil class file.
 * @package newsletter\utils
 */
class NewsletterUtil
{   
    /**
     * Process newsletter noification.
     * @param array $storeOwner
     * @param array $toAddressArray
     * @param Newsletter $model
     * @return type
     */
    public static function processNewsletterNotifications($storeOwner, $toAddressArray, $model)
    {
        if(!empty($toAddressArray))
        {
            foreach ($toAddressArray  as  $toAddress)
            {
                $fromAddress        = $storeOwner['email'];
                $fromName           = $storeOwner['firstname']. ' '. $storeOwner['lastname'];
                $emailNotification  = new CustomerNewsletterNotification(['newsletter' => $model, 'toAddress' => $toAddress]);
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
     * Get to email address.
     * @param int $customerId
     * @return string
     */
    public static function getToAddress($customerId)
    {
        $customerTable      = UsniAdaptor::tablePrefix() . 'customer';
        $personTable        = UsniAdaptor::tablePrefix() . 'person';
        $sql                = "SELECT tp.email
                               FROM $customerTable tc,  $personTable tp
                               WHERE tc.id = :cid AND tc.person_id = tp.id";
        $connection         = UsniAdaptor::app()->getDb();
        $record             =  $connection->createCommand($sql, [':cid' => $customerId])->queryOne();
        return $record['email'];
        
    }
    
    /**
     * Get To newsletter dropdown.
     * @return array
     */
    public static function getToNewsletterDropdown()
    {
        return [
                    Newsletter::ALL_SUBSCRIBERS  => UsniAdaptor::t('newsletter', 'All Subscribers'),
                    Newsletter::ALL_CUSTOMERS    => UsniAdaptor::t('newsletter', 'All Customers')
               ];
    }
    
    /**
     * Send newsletter script.
     * @param \yii\web\View $view
     * @param string $url
     * @param string $formId
     * @param string $modalId
     * @return void.
     */
    public static function registerSendNewsletterScripts($view, $url, $formId, $modalId)
    {
        $script             = "$('#{$formId}').on('beforeSubmit',
                                     function(event, jqXHR, settings)
                                     {
                                        var form = $(this);
                                        if(form.find('.has-error').length) {
                                                return false;
                                        }
                                        $.ajax({
                                                    url: '{$url}',
                                                    type: 'post',
                                                    data: form.serialize(),
                                                    'beforeSend' : function()
                                                                {
                                                                    attachButtonLoader(form);
                                                                    $('.alert-newsletter').hide();
                                                                },
                                                })
                                        .done(function(data, statusText, xhr){
                                                                $('#newsletterform').hide();
                                                                $('#newslettersuccessmessage').show();
                                                                removeButtonLoader(form);
                                                              });

                                                return false;
                                     })";
        $view->registerJs($script);
    }
}
