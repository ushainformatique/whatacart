<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\notifications;

use usni\UsniAdaptor;
/**
 * ChangePasswordEmailNotification class file.
 *
 * @package customer\notifications
 */
class ChangePasswordEmailNotification extends \usni\library\modules\users\notifications\ChangePasswordEmailNotification
{
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
    protected function getTemplateData()
    {
        return array('{{fullName}}' => $this->getFullName(),
                     '{{username}}' => $this->user->username,
                     '{{password}}' => $this->user->newPassword,
                     '{{loginUrl}}' => UsniAdaptor::createUrl('customer/default/login'),
                     '{{appname}}'  => UsniAdaptor::app()->name);
    }
}