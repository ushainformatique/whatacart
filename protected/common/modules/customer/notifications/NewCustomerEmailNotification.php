<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\notifications;

use customer\models\Customer;
/**
 * NewCustomerEmailNotification class file.
 * 
 * @package customer\notifications
 */
class NewCustomerEmailNotification extends \usni\library\modules\users\notifications\NewUserEmailNotification
{
    /**
     * @inheritdoc
     */
    public function getKey()
    {
        return Customer::NOTIFY_CREATECUSTOMER;
    }

    /**
     * @inheritdoc
     */
    public function getModuleName()
    {
        return 'customer';
    }

    /**
     * Get validate url
     * @return string
     */
    protected function getValidateUrl()
    {
        return '/customer/site/validate-email-address';
    }
    
    /**
     * @inheritdoc
     */
    protected function getConfirmEmailUrl()
    {
        $confirmEmailUrl = parent::getConfirmEmailUrl();
        if(strpos($confirmEmailUrl, '/backend/index.php'))
        {
            $confirmEmailUrl = str_replace('/backend', '', $confirmEmailUrl);
        }
        return $confirmEmailUrl;
    }
}