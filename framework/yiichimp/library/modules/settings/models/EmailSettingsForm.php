<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\settings\models;

use usni\UsniAdaptor;
use usni\library\validators\EmailValidator;
use usni\library\modules\settings\notifications\TestMessageEmailNotification;
use usni\library\modules\notification\models\Notification;
use usni\library\notifications\BaseNotificationService;
/**
 * EmailSettingsForm class file.
 * 
 * @package usni\library\modules\settings\models
 */
class EmailSettingsForm extends \yii\base\Model
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
    
    public $fromName;

    public $fromAddress;

    public $replyToAddress;

    public $sendingMethod;

    //public $pathToSendmail;

    public $testEmailAddress;

    public $sendTestMail;

    public $smtpHost;

    public $smtpPort;

    public $smtpUsername;

    public $smtpPassword;

    public $smtpAuth;
    
    public $testMode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                    [['fromName', 'fromAddress', 'replyToAddress', 'sendingMethod'],                            'required'],
                    //['sendingMethod', 'isValidSmtpInfo'],
                    [['smtpHost', 'smtpPort', 'smtpUsername', 'smtpPassword'], 'required', 'when' => [$this, 'applySmtpValidation'],
                      'whenClient' => "function (attribute, value) {
                                            return $('#emailsettingsform-sendingmethod').val() == 'smtp';
                                       }"],
                    [['testEmailAddress', 'smtpHost', 'smtpPort', 'smtpUsername', 'smtpPassword', 'smtpAuth', 'testMode'],  'safe'],
                    [['sendTestMail', 'smtpAuth'],                                                              'default',      'value' => 0],
                    ['fromName',                                                                                'string'],
                    [['fromAddress', 'replyToAddress', 'testEmailAddress'],                                      EmailValidator::className()],
               ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
                    'fromName'              => UsniAdaptor::t('notification', 'From Name'),
                    'fromAddress'           => UsniAdaptor::t('notification', 'From Address'),
                    'replyToAddress'        => UsniAdaptor::t('notification', 'Reply To Address'),
                    'testEmailAddress'      => UsniAdaptor::t('notification', 'Test Email Address'),
                    'sendingMethod'         => UsniAdaptor::t('notification', 'Sending Method'),
                    //'pathToSendmail'        => UsniAdaptor::t('notification', 'pathToSendmail'),
                    'smtpHost'              => UsniAdaptor::t('notification', 'SMTP Host'),
                    'smtpPort'              => UsniAdaptor::t('notification', 'SMTP Port'),
                    'smtpUsername'          => UsniAdaptor::t('notification', 'SMTP Username'),
                    'smtpPassword'          => UsniAdaptor::t('notification', 'SMTP Password'),
                    'smtpAuth'              => UsniAdaptor::t('notification', 'Use SMTP Authentication'),
                    'testMode'              => UsniAdaptor::t('notification', 'Enable test mode')
               ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
                    'fromName'              => UsniAdaptor::t('notificationhint', 'Default from name of the system user sending the email.'),
                    'fromAddress'           => UsniAdaptor::t('notificationhint', 'Default from address of the system user sending the email.'),
                    'replyToAddress'        => UsniAdaptor::t('notificationhint', 'Default reply to address in the system.'),
                    'testEmailAddress'      => UsniAdaptor::t('notificationhint', 'Test email address'),
                    'sendingMethod'         => UsniAdaptor::t('notificationhint', 'Sending Method'),
                    //'pathToSendmail'        => t('notification', 'pathToSendmail'),
                    'smtpHost'              => UsniAdaptor::t('notificationhint', 'SMTP Host'),
                    'smtpPort'              => UsniAdaptor::t('notificationhint', 'SMTP Port'),
                    'smtpUsername'          => UsniAdaptor::t('notificationhint', 'SMTP Username'),
                    'smtpPassword'          => UsniAdaptor::t('notificationhint', 'SMTP Password'),
                    'smtpAuth'              => UsniAdaptor::t('notificationhint', 'Use SMTP Authentication'),
                    'testMode'              => UsniAdaptor::t('notification', 'Enable test mode where notification data would be stored in log tables in database.')
               ];
    }
    
    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return UsniAdaptor::t('settings', 'Email Settings');
    }
    
    /**
     * Sends test email
     * @return void
     */
    public function sendTestMail()
    {
        $this->emailNotification    = new TestMessageEmailNotification();
        $mailer                     = UsniAdaptor::app()->mailer;
        $message                    = $mailer->compose('@usni/library/mail/views/html', ['content' => $this->emailNotification->body]);
        $isSent = $message->setFrom([$this->fromAddress => $this->fromName])
                ->setTo($this->testEmailAddress)
                ->setSubject($this->emailNotification->subject)
                ->send();
        $data               = serialize(array(
                                'fromName'    => $this->fromName,
                                'fromAddress' => $this->fromAddress,
                                'toAddress'   => $this->testEmailAddress,
                                'subject'     => $this->emailNotification->subject,
                                'body'        => $message->toString()));
        $status             = $isSent === true ? Notification::STATUS_SENT : Notification::STATUS_PENDING;
        //Save notification
        return $this->saveEmailNotification($status, $data);
    }
    
    /**
     * Should smtp validation be applied
     * @param Model $model
     * return boolean
     */
    public function applySmtpValidation($model)
    {
        if($model->sendingMethod == 'smtp')
        {
            return true;
        }
        return false;
    }
}