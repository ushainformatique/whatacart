<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\models;

use usni\library\validators\UiEmailValidator;
use usni\library\modules\notification\utils\NotificationUtil;
use usni\library\modules\notification\models\Notification;
use customer\notifications\ForgotPasswordEmailNotification;
use usni\UsniAdaptor;
/**
 * ForgotPasswordForm class file
 *
 * @package customer\models
 */
class ForgotPasswordForm extends \yii\base\Model
{
    /**
     * Customer email
     * @var string 
     */
    public $email;
    
    /**
     * User associated
     * @var array 
     */
    public $user;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                    ['email', 'required'],
                    ['email', UiEmailValidator::className()]
            ];
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['forgotpassword'] = ['email'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return null;
    }
    
    /**
     * Sends user registration email
     * @return boolean
     */
    public function sendMail()
    {
        $mailer             = UsniAdaptor::app()->mailer;
        $emailNotification  = new ForgotPasswordEmailNotification(['user' => $this->user]);
        $mailer->emailNotification = $emailNotification;
        $message            = $mailer->compose();
        $toAddress          = $this->user['email'];
        list($fromName, $fromAddress) = NotificationUtil::getSystemFromAddressData();
        $isSent             = $message->setFrom([$fromAddress => $fromName])
                            ->setTo($toAddress)
                            ->setSubject($emailNotification->getSubject())
                            ->send();
        $data               = serialize(array(
                                'fromName'    => $fromName,
                                'fromAddress' => $fromAddress,
                                'toAddress'   => $toAddress,
                                'subject'     => $emailNotification->getSubject(),
                                'body'        => $message->toString()));
        $status             = $isSent === true ? Notification::STATUS_SENT : Notification::STATUS_PENDING;
        //Save notification
        return NotificationUtil::saveEmailNotification($emailNotification, $status, $data);
    }
}
