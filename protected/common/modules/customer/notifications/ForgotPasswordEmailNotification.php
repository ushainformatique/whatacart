<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\notifications;

use usni\UsniAdaptor;
/**
 * ForgotPasswordEmailNotification class file.
 *
 * @package customer\notifications
 */
class ForgotPasswordEmailNotification extends \usni\library\modules\users\notifications\ForgotPasswordEmailNotification
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
    protected function getLoginUrl()
    {
        return UsniAdaptor::createUrl('customer/site/login');
    }
    
    /**
     * Get table name
     * @return string
     */
    protected function getTableName()
    {
        return UsniAdaptor::tablePrefix() . 'customer';
    }
}
?>