<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license http://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\marketing\services;

use common\modules\marketing\models\SendMailForm;
use common\modules\marketing\notifications\CustomerSendMailNotification;
use common\modules\marketing\events\SendMailEvent;
use usni\library\modules\notification\models\Notification;
use usni\UsniAdaptor;
use newsletter\events\SendNewsletterEvent;
use newsletter\notifications\CustomerNewsletterNotification;
use newsletter\models\Newsletter;
/**
 * NotificationService class file.
 * 
 * @package common\modules\marketing\services
 */
class NotificationService extends \usni\library\notifications\BaseNotificationService
{
    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
                    SendMailForm::EVENT_SENDMAIL        => [$this, 'sendMailNotification'],
                    Newsletter::EVENT_SENDNEWSLETTER    => [$this, 'sendNewsletterNotification']
               ];
    }
    
    /**
     * Send mail notification
     * 
     * @param SendMailEvent $event
     * @return boolean
     */
    public function sendMailNotification(SendMailEvent $event)
    {
        $this->emailNotification  = new CustomerSendMailNotification(['model' => $event->model, 
                                                                      'toAddress' => $event->toAddress,
                                                                      'language' => $this->owner->language]);
        $this->processSendMail($event->storeOwner);
    }
    
    /**
     * Send newsletter notification
     * 
     * @param SendNewsletterEvent $event
     * @return boolean
     */
    public function sendNewsletterNotification(SendNewsletterEvent $event)
    {
        $this->emailNotification  = new CustomerNewsletterNotification(['model' => $event->model, 
                                                                        'toAddress' => $event->toAddress,
                                                                        'language' => $this->owner->language]);
        $this->processSendMail($event->storeOwner);
    }
    
    /**
     * Process send mail.
     * @param array $storeOwner
     * @return boolean
     */
    public function processSendMail($storeOwner)
    {
        $fromAddress        = $storeOwner['email'];
        $fromName           = $storeOwner['firstname']. ' '. $storeOwner['lastname'];
        $mailer             = UsniAdaptor::app()->mailer;
        $message            = $mailer->compose('@usni/library/mail/views/html', ['content' => $this->emailNotification->body]);
        $message->setFrom([$fromAddress => $fromName])
                ->setTo($this->emailNotification->toAddress);
        $isSent             = $message->setSubject($this->emailNotification->model->subject)->send();
        $data               = serialize(array(
                                'fromName'    => $fromName,
                                'fromAddress' => $fromAddress,
                                'toAddress'   => $this->emailNotification->toAddress,
                                'subject'     => $this->emailNotification->model->subject,
                                'body'        => $message->toString()));
        $status             = $isSent === true ? Notification::STATUS_SENT : Notification::STATUS_PENDING;
        //Save notification
        return $this->saveEmailNotification($status, $data);
    }
}
