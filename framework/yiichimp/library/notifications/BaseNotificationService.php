<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\notifications;

use usni\library\notifications\EmailNotification;
use usni\library\modules\notification\models\Notification;
use usni\library\modules\users\models\User;
use usni\UsniAdaptor;
use usni\library\modules\users\dao\UserDAO;
use usni\library\utils\ArrayUtil;

/**
 * Base class for notification service
 *
 * @package usni\library\notifications
 */
class BaseNotificationService extends \yii\base\Behavior
{
    /**
     * @var string|array 
     */
    public $fromName;
    /**
     * @var string|array 
     */
    public $fromAddress;
    /**
     * @var EmailNotification 
     */
    public $emailNotification;
    /**
     * @var string|array 
     */
    public $to;
    /**
     * @var string|array 
     */
    public $cc;
    /**
     * @var string|array 
     */
    public $bcc;
    /**
     * @var string
     */
    public $subject;
    
    /**
     * @var array 
     */
    public $attachments = [];
    
    /**
     * inheritdoc
     */
    public function init()
    {
        list($this->fromName, $this->fromAddress) = $this->getSystemFromAddressData();
    }
    
    /**
     * Save email notification.
     * @param int $status
     * @param string $data
     * @return boolean
     */
    public function saveEmailNotification($status, $data)
    {
        $tableName      = UsniAdaptor::app()->db->tablePrefix . 'notification';
        $columns        = [ 'modulename' => $this->emailNotification->getModuleName(), 
                            'type' => Notification::TYPE_EMAIL, 
                            'data' => $data, 
                            'priority' => $this->emailNotification->getDeliveryPriority(), 
                            'status' => $status,
                            'senddatetime' => date('Y-m-d H:i:s'), 
                            'created_by' => User::SUPER_USER_ID, 
                            'created_datetime' => date('Y-m-d H:i:s')];
        return UsniAdaptor::app()->db->createCommand()->insert($tableName, $columns)->execute();
    }
    
    /**
     * Process sending of notification
     * 
     * @return boolean
     */
    public function processSend()
    {
        $mailer             = UsniAdaptor::app()->mailer;
        $message            = $mailer->compose('@usni/library/mail/views/html', ['content' => $this->emailNotification->body]);
        $message->setFrom([$this->fromAddress => $this->fromName])
                ->setTo($this->to);
        if(!empty($this->cc))
        {
            $message->setCc($this->cc);
        }
        if(!empty($this->bcc))
        {
            $message->setBcc($this->bcc);
        }
        if(!empty($this->attachments))
        {
            foreach($this->attachments as $attachment)
            {
                $message->attach($attachment);
            }
        }
        $isSent             = $message->setSubject($this->emailNotification->subject)->send();
        $data               = serialize(array(
                                'fromName'    => $this->fromName,
                                'fromAddress' => $this->fromAddress,
                                'toAddress'   => $this->to,
                                'subject'     => $this->emailNotification->subject,
                                'body'        => $this->emailNotification->body));
        $status             = $isSent === true ? Notification::STATUS_SENT : Notification::STATUS_PENDING;
        //Save notification
        return $this->saveEmailNotification($status, $data);
    }
    
    /**
     * Get system from address data. It would be used as default from address data
     * @return array
     */
    public function getSystemFromAddressData()
    {
        $email  = null;
        $name   = null;
        $data   = UsniAdaptor::app()->configManager->getValue('settings', 'emailSettings');
        if($data != null)
        {
            $settings = unserialize($data);
            $email    = ArrayUtil::getValue($settings, 'fromAddress', null);
            $name     = ArrayUtil::getValue($settings, 'fromName', null);
        }
        $super  = UserDAO::getById(User::SUPER_USER_ID);
        if($email == null && $super !== false)
        {
            $email = $super['email'];
        }
        if($name == null && $super !== false)
        {
            $name = $super['firstname'] . ' ' . $super['lastname'];
        }
        return [$name, $email];
    }
}
