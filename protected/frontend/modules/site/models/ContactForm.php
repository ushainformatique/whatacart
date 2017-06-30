<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\modules\site\models;

use usni\UsniAdaptor;
use frontend\modules\site\notifications\ContactEmailNotification;
use usni\library\notifications\BaseNotificationService;
/**
 * ContactForm class file.
 * 
 * @package frontend\modules\site\models
 */
class ContactForm extends \yii\base\Model
{
    /**
     * inheritdoc
     */
    public function behaviors()
    {
        return [
                    BaseNotificationService::className()  
               ];
    }
    
    /**
     * Name during contact us.
     * @var string
     */
    public $name;

    /**
     * Email during contact us.
     * @var string
     */
    public $email;
    /**
     * Store subject during contact us.
     * @var string
     */
    public $subject;
    /**
     * Store phone during contact us.
     * @var string
     */
    public $phone;
    /**
     * Store message during contact us.
     * @var string
     */
    public $message;
    /**
     * Store verifyCode during contact us.
     * @var string
     */
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                   [['name', 'email', 'subject', 'message', 'verifyCode'], 'required'],
                   ['email', 'email'],
                   ['phone', 'number'],
                   ['verifyCode', 'captcha', 'captchaAction' => '/site/default/captcha'],
               ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
                    'name'       => UsniAdaptor::t('application', 'Name'),
                    'email'      => UsniAdaptor::t('users', 'Email'),
                    'subject'    => UsniAdaptor::t('application', 'Subject'),
                    'message'    => UsniAdaptor::t('application', 'Message'),
                    'phone'      => UsniAdaptor::t('application', 'Phone'),
                    'verifyCode' => UsniAdaptor::t('application', 'Verify Code'),
               ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [];
    }
    
    /**
     * Sends user registration email
     * @return boolean
     */
    public function sendMail()
    {
        $fromAddress                = $this->fromAddress;
        $this->emailNotification    = new ContactEmailNotification(['formModel' => $this]);
        $this->fromName             = $this->name;
        $this->fromAddress          = $this->email;
        $this->to                   = $fromAddress;
        return $this->processSend();
    }
}