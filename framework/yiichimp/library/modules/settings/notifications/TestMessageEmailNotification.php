<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\settings\notifications;

use usni\library\notifications\EmailNotification;
use usni\UsniAdaptor;
use usni\library\modules\notification\models\Notification;
/**
 * TestMessageEmailNotification class file.
 * 
 * @package usni\library\modules\settings\notifications
 */
class TestMessageEmailNotification extends EmailNotification
{
    /**
     * @inheritdoc
     */
    public function getKey()
    {
        return 'testmessage';
    }

    /**
     * @inheritdoc
     */
    public function getModuleName()
    {
        return 'settings';
    }

    /**
     * @return int
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
        return array('{{message}}' => UsniAdaptor::t('settings', 'This is a test message'),
                     '{{appname}}'  => UsniAdaptor::app()->name);
    }

    /**
     * @inheritdoc
     */
    protected function getLayoutData($data)
    {
        return array('{{####content####}}' => $data['templateContent']);
    }
}