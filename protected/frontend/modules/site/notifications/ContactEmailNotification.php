<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\modules\site\notifications;

use usni\library\modules\notification\models\Notification;
use usni\library\notifications\EmailNotification;
/**
 * ContactEmailNotification class file.
 * 
 * @package frontend\modules\site\notifications
 */
class ContactEmailNotification extends EmailNotification
{
    public $formModel;
    
    /**
     * @inheritdoc
     */
    public function getKey()
    {
        return 'contactus';
    }

    /**
     * @inheritdoc
     */
    public function getModuleName()
    {
        return 'front';
    }

    /**
     * @inheritdoc
     */
    public function getDefaultNotificationStatus()
    {
        return Notification::STATUS_PENDING;
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
    public function getTemplateData()
    {
        return array('{{name}}'     => $this->formModel->name,
                     '{{email}}'    => $this->formModel->email,
                     '{{subject}}'  => $this->formModel->subject,
                     '{{message}}'  => $this->formModel->message);
    }

    /**
     * Gets layout data.
     * @param array $data
     * @return array
     */
    public function getLayoutData($data)
    {
        return array('{{####content####}}' => $data['templateContent']);
    }
    
    /**
     * @inheritdoc
     */
    public function setSubject()
    {
        $this->subject = $this->formModel->subject;
    }
}