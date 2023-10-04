<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\notification\utils;

use usni\library\modules\notification\models\Notification;
use usni\UsniAdaptor;
use usni\library\utils\ArrayUtil;
use yii\helpers\Url;
/**
 * Contains helper functions for notifications.
 * 
 * @package usni\library\modules\notification\utils
 */
class NotificationUtil
{
    /**
     * Gets priority display label.
     * @param integer $status
     * @return string
     */
    public static function getPriorityDisplayLabel($status)
    {
        $priorityLabelData = NotificationUtil::getPriorityListData();
        if(($label = ArrayUtil::getValue($priorityLabelData, $status)) !== null)
        {
            return $label;
        }
        return UsniAdaptor::t('application', '(not set)');
    }

    /**
     * Get status for notifications.
     * @return array
     */
    public static function getStatusListData()
    {
        return array(
            Notification::STATUS_SENT       => UsniAdaptor::t('application', 'Sent'),
            Notification::STATUS_PENDING    => UsniAdaptor::t('application', 'Pending')
        );
    }
    
    /**
     * Get priority for notifications.
     * @return array
     */
    public static function getPriorityListData()
    {
        return array(
            Notification::PRIORITY_LOW      => UsniAdaptor::t('notification', 'Low'),
            Notification::PRIORITY_NORMAL   => UsniAdaptor::t('notification', 'Medium'),
            Notification::PRIORITY_HIGH     => UsniAdaptor::t('notification', 'High')
        );
    }

    /**
     * Get types of notifications.
     * @return array
     */
    public static function getTypes()
    {
        return array(
            Notification::TYPE_EMAIL => UsniAdaptor::t('users', 'Email')
        );
    }

    /**
     * Get Sending method of mail. eg. simple|SMTP
     */
    public static function getMailSendingMethod()
    {
        return array('mail'     => UsniAdaptor::t('notification', 'Mail'),
                     //'sendmail' => UsniAdaptor::getLabel('notification', 'sendmail'),
                     'smtp'     => UsniAdaptor::t('notification', 'SMTP'));
    }

    /**
     * Get application base url used for notification.
     * @return string
     * @see NewUserEmailNotification
     */
    public static function getApplicationBaseUrl()
    {
        $baseUrl = Url::base(true);
        if(UsniAdaptor::app()->urlManager->showScriptName == true)
        {
            $baseUrl .= '/index.php';
        }
        return $baseUrl;
    }
}