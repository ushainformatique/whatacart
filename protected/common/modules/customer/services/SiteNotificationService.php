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
use customer\business\Manager AS CustomerBusinessManager;
/**
 * NotificationService class file.
 * 
 * @package customer\services
 */
class SiteNotificationService extends NotificationService
{   
    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
                    Customer::EVENT_CHANGE_PASSWORD => [$this, 'sendChangePasswordNotification'],
                    Customer::EVENT_AFTER_INSERT => [$this, 'processAfterInsert']
               ];
    }
    
    /**
     * Process after insert.
     * 
     * @param CreateUserEvent $event
     * @return boolean
     */
    public function processAfterInsert($event)
    {
        $user = $event->user;
        $this->emailNotification    = new NewCustomerEmailNotification(['user' => $user, 
                                                                        'person' => $user->person,
                                                                        'language' => $this->owner->language]);
        $this->to = $event->user->person->email;
        $this->processSend();
        //Add activity
        $this->addActivity($user);
    }
    
    /**
     * Add activity.
     * @param Customer $user
     */
    public function addActivity($user)
    {
        $customerBusinessInstance   = CustomerBusinessManager::getInstance();
        $activityData               = ['customer_id' => $user->id, 
                                       'name' => $customerBusinessInstance->getFullName($user->person->firstname, $user->person->lastname)];
        $customerBusinessInstance->addActivity('register', $activityData);
    }
    
    /**
     * Send change password notification.
     * @param ChangePasswordEvent $event
     * @return integer
     */
    public function sendChangePasswordNotification($event)
    {
        $user = $event->user;
        $this->emailNotification  = new ChangePasswordEmailNotification(['user' => $user, 
                                                                         'person' => $user->person,
                                                                         'language' => $this->owner->language]);
        $this->to = $user->person->email;
        $this->processSend();
    }
}