<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\models;

use usni\library\validators\EmailValidator;
use customer\notifications\ForgotPasswordEmailNotification;
use customer\services\NotificationService;
use usni\UsniAdaptor;
/**
 * ForgotPasswordForm class file
 *
 * @package customer\models
 */
class ForgotPasswordForm extends \yii\base\Model
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
                    'notifyService' => NotificationService::className(),
               ];
    }
    
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
                    ['email', EmailValidator::className()]
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
     * Sends forgot password mail.
     */
    public function sendMail()
    {
        $this->emailNotification            = new ForgotPasswordEmailNotification(['user' => $this->user]);
        $this->to                           = $this->user['email'];
        $this->emailNotification->subject   = UsniAdaptor::t('customer', 'Forgot Password Request');
        $this->processSend();
    }
}
