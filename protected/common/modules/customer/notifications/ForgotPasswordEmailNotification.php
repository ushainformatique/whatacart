<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\notifications;

use usni\UsniAdaptor;
use customer\models\Customer;
use usni\library\modules\notification\models\Notification;
use usni\library\notifications\EmailNotification;
use usni\library\modules\users\utils\UserUtil;
/**
 * ForgotPasswordEmailNotification class file.
 *
 * @package customer\notifications
 */
class ForgotPasswordEmailNotification extends EmailNotification
{
    /**
     * @var array 
     */
    public $user;
    
    /**
     * @inheritdoc
     */
    public function getKey()
    {
        return Customer::NOTIFY_FORGOTPASSWORD;
    }
    
    /**
     * @inheritdoc
     */
    public function getModuleName()
    {
        return 'customer';
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
        $password = $this->resetPassword();
        return array('{{fullName}}' => $this->user['firstname'] . ' ' . $this->user['lastname'],
                     '{{username}}' => $this->user['username'],
                     '{{password}}' => $password,
                     '{{loginUrl}}' => $this->getLoginUrl(),
                     '{{appname}}'  => UsniAdaptor::app()->name
                    );
    }
    
    /**
     * @inheritdoc
     */
    protected function getLayoutData($data)
    {
        return ['{{####content####}}' => $data['templateContent']];
    }

    /**
     * @inheritdoc
     */
    protected function getLoginUrl()
    {
        return UsniAdaptor::createUrl('customer/site/login');
    }
    
    /**
     * Reset password hash.
     * @return mixed $password.
     */
    protected function resetPassword()
    {
        $password       = UserUtil::generateRandomPassword() . UserUtil::generateSpecialChar();
        $passwordHash   = UsniAdaptor::app()->security->generatePasswordHash($password);
        $table          = UsniAdaptor::tablePrefix() . 'customer';
        $data           = ['password_hash' => $passwordHash];
        UsniAdaptor::app()->db->createCommand()->update($table, $data, 'id = :id', [':id' => $this->user['id']])->execute();
        return $password;
    }
}