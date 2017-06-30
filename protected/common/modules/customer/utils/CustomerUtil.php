<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\utils;

use usni\UsniAdaptor;
use usni\library\utils\ArrayUtil;
use usni\library\modules\users\models\Address;
/**
 * Contains utility functions related to Customer.
 *
 * @package customer\utils
 */
class CustomerUtil
{
    /**
     * Get address type dropdown.
     * @return array
     */
    public static function getAddressTypeDropdown()
    {
        return [
                    Address::TYPE_SHIPPING_ADDRESS  => UsniAdaptor::t('customer', 'Shipping Address'),
                    Address::TYPE_BILLING_ADDRESS   => UsniAdaptor::t('customer', 'Billing Address'),
                    Address::TYPE_DEFAULT           => UsniAdaptor::t('customer', 'Default Address')
               ];
    }
    
    /**
     * Get email for the user.
     * @param string $username
     * @param string $email
     * @return string
     */
    public static function getEmail($username, $email)
    {
        if ($email == null)
        {
            return $username . '@whatacart.com';
        }
        else
        {
            return $email;
        }
    }
    
    /**
     * Get formatted customer activity key.
     * @param string $key
     * @return mixed
     */
    public static function getFormattedCustomerActivityKey($key)
    {
        $formattedKeys = [
                            'new_registration'      => UsniAdaptor::t('customer', 'registered for an account.'),
                            'account_order_created' => UsniAdaptor::t('customer', 'created a new order.'),
                            'login'                 => UsniAdaptor::t('customer', 'logged in.'),
                            'edit_profile'          => UsniAdaptor::t('customer', 'updated their account details.'),
                            'forgot_password'       => UsniAdaptor::t('customer', 'requested a new password.'),
                            'change_password'       => UsniAdaptor::t('customer', 'updated their account password.'),
                            'add_address'           => UsniAdaptor::t('customer', 'added a new address.')
                         ];
        return ArrayUtil::getValue($formattedKeys, $key);
    }
}