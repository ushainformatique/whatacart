<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\users\utils;

use usni\UsniAdaptor;
use usni\library\modules\users\models\User;
/**
 * Contains utility functions related to Users.
 * 
 * @package usni\library\modules\users\utils
 */
class UserUtil
{
    /**
     * Get address labels
     * @return array
     */
    public static function getAddressLabels()
    {
        return [
            'address1'          => UsniAdaptor::t('users', 'Address1'),
            'address2'          => UsniAdaptor::t('users', 'Address2'),
            'city'              => UsniAdaptor::t('city', 'City'),
            'state'             => UsniAdaptor::t('state', 'State'),
            'country'           => UsniAdaptor::t('country', 'Country'),
            'postal_code'       => UsniAdaptor::t('users', 'Postal Code'),
            'status'            => UsniAdaptor::t('application', 'Status'),
            'relatedmodel'      => UsniAdaptor::t('users','Related Model'),
            'relatedmodel_id'   => UsniAdaptor::t('users','Related Id'),
            'useBillingAddress' => UsniAdaptor::t('users','Same As Billing Address'),
        ];
    }
    
    /**
     * Get person labels
     * @return array
     */
    public static function getPersonLabels()
    {
        return [
                    'id'                => UsniAdaptor::t('application', 'Id'),
                    'firstname'         => UsniAdaptor::t('users','First Name'),
                    'lastname'          => UsniAdaptor::t('users','Last Name'),
                    'mobilephone'       => UsniAdaptor::t('users','Mobile'),
                    'email'             => UsniAdaptor::t('users','Email'),
                    'fullName'          => UsniAdaptor::t('users','Full Name'),
                    'profile_image'     => UsniAdaptor::t('users','Profile Image')
                ];
    }
    
    /**
     * Get user labels
     * @return array
     */
    public static function getUserLabels()
    {
        return [
            'username'          => UsniAdaptor::t('users', 'Username'),
            'password'          => UsniAdaptor::t('users', 'Password'),
            'confirmPassword'   => UsniAdaptor::t('users', 'Confirm Password'),
            'timezone'          => UsniAdaptor::t('users', 'Timezone'),
            'status'            => UsniAdaptor::t('application', 'Status'),
            'groups'            => UsniAdaptor::t('auth',  'Group')
        ];
    }
    
    /**
     * Get password instructions.
     * @return string
     */
    public static function getPasswordInstructions()
    {
        return UsniAdaptor::t('userflash', '<div class="notifications">
                                                    <ul>
                                                        <li>Must contains one digit from 0-9</li>
                                                        <li>Must contains one alphabet(case insensitive)</li>
                                                        <li>Must contains one special symbol</li>
                                                        <li>Match anything with previous condition checking
                                                                {6,20} length at least 6 characters and maximum of 20</li>
                                                    </ul>
                                                </div>');
    }
    
    /**
     * Generate random password.
     * @return string.
     */
    public static function generateRandomPassword()
    {
        $chars      = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $password   = substr( str_shuffle( $chars ), 0, 8);
        return $password;
    }
    
    /**
     * Generate special character.
     * @return string.
     */
    public static function generateSpecialChar()
    {
        $chars      = "!@#$%^&*";
        $chosenChar   = substr( str_shuffle( $chars ), 0, 1);
        return $chosenChar;
    }
    
     /**
     * Gets status drop down.
     * @return array
     */
    public static function getStatusDropdown()
    {
        return [
                    User::STATUS_ACTIVE     => UsniAdaptor::t('application','Active'),
                    User::STATUS_INACTIVE   => UsniAdaptor::t('application','Inactive'),
                    User::STATUS_PENDING    => UsniAdaptor::t('application','Pending')
               ];
    }
}