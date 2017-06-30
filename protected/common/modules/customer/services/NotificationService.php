<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\services;

use customer\models\Customer;
use customer\notifications\NewCustomerEmailNotification;
use usni\library\modules\users\events\ChangePasswordEvent;
use customer\notifications\ChangePasswordEmailNotification;
use usni\library\modules\users\events\CreateUserEvent;
use usni\library\modules\users\models\User;
/**
 * NotificationService class file.
 * 
 * @package customer\services
 */
class NotificationService extends \usni\library\notifications\BaseNotificationService
{   
    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
                    User::EVENT_CHANGE_PASSWORD => [$this, 'sendChangePasswordNotification'],
                    Customer::EVENT_AFTER_INSERT => [$this, 'sendNewCustomerNotification']
               ];
    }
    
    /**
     * Send new customer notification.
     * 
     * @param CreateUserEvent $event
     * @return boolean
     */
    public function sendNewCustomerNotification($event)
    {
        $user = $event->user;
        $this->emailNotification    = new NewCustomerEmailNotification(['user' => $user, 
                                                                        'person' => $user->person,
                                                                        'language' => $this->owner->language]);
        $this->to = $user->person->email;
        $this->processSend();
    }
    
    /**
     * Send change password notification.
     * @param ChangePasswordEvent $event
     * @return integer
     */
    public function sendChangePasswordNotification($event)
    {
        $this->emailNotification  = new ChangePasswordEmailNotification(['user' => $event->user, 
                                                                         'person' => $event->user->person,
                                                                         'language' => $this->owner->language]);
        $this->to = $event->user->person->email;
        $this->processSend();
    }
}