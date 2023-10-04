<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\users\notifications;

use usni\library\notifications\EmailNotification;
use usni\library\modules\notification\models\Notification;
use usni\library\modules\users\models\User;
use usni\UsniAdaptor;
use usni\library\modules\users\business\Manager;
/**
 * ChangePasswordEmailNotification class file.
 * 
 * @package usni\library\modules\users\notifications
 */
class ChangePasswordEmailNotification extends EmailNotification
{
    /**
     * User for whom password is changed
     * @var User 
     */
    public $user;
    
    /**
     * Person registered with the system
     * @var Person 
     */
    public $person;
    
    /**
     * @inheritdoc
     */
    public function getKey()
    {
        return User::NOTIFY_CHANGEPASSWORD;
    }

    /**
     * @inheritdoc
     */
    public function getModuleName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function getDeliveryPriority()
    {
        return Notification::PRIORITY_HIGH;
    }

    /**
     * @inheritdoc
     */
    protected function getTemplateData()
    {
        return array('{{fullName}}' => $this->getFullName(),
                     '{{username}}' => $this->user->username,
                     '{{password}}' => $this->user->newPassword,
                     '{{appname}}'  => UsniAdaptor::app()->name);
    }

    /**
     * @inheritdoc
     */
    protected function getLayoutData($data)
    {
        return ['{{####content####}}' => $data['templateContent']];
    }
    
    /**
     * Get full name.
     * @return string
     */
    protected function getFullName()
    {
        $manager = new Manager();
        return $manager->getFullName($this->person->firstname, $this->person->lastname);
    }
}