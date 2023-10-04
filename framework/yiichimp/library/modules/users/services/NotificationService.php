<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\users\services;

use usni\library\modules\users\models\User;
use usni\library\modules\users\events\ChangePasswordEvent;
use usni\library\modules\users\notifications\ChangePasswordEmailNotification;
use usni\library\modules\users\events\CreateUserEvent;
use usni\library\modules\users\notifications\NewUserEmailNotification;
/**
 * NotificationService class file.
 * 
 * @package usni\library\modules\users\services
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
                    User::EVENT_AFTER_INSERT => [$this, 'sendNewUserNotification']
               ];
    }
    
    /**
     * Send new user notification.
     * 
     * @param CreateUserEvent $event
     * @return boolean
     */
    public function sendNewUserNotification(CreateUserEvent $event)
    {
        if($event->user->id != User::SUPER_USER_ID)
        {
            $this->emailNotification  = new NewUserEmailNotification(['user' => $event->user, 
                                                                      'person' => $event->user->person,
                                                                      'language' => $this->owner->language]);
            $this->to = $event->user->person->email;
            $this->processSend();
        }
    }
    
    /**
     * Send change password notification.
     * @param ChangePasswordEvent $event
     * @return integer
     */
    public function sendChangePasswordNotification(ChangePasswordEvent $event)
    {
        $this->emailNotification  = new ChangePasswordEmailNotification(['user' => $event->user, 
                                                                         'person' => $event->user->person,
                                                                         'language' => $this->owner->language]);
        $this->to = $event->user->person->email;
        $this->processSend();
    }
}