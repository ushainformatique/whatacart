<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\users\models;

use yii\base\Model;
use usni\UsniAdaptor;
/**
 * Change password form model
 *
 * @package usni\library\modules\users\models
 */
class ChangePasswordForm extends Model
{
    /**
     * New password to be set.
     * @var string
     */
    public $newPassword;

    /**
     * Confirm passoword against new password.
     * @var string
     */
    public $confirmPassword;

    /**
     * User associated.
     * @var Model
     */
    public $user;
    
    /**
     * Person associated
     * @var Person 
     */
    public $person;

    /**
     * Validation rules for the model.
     * @return array Validation rules for model attributes.
     */
    public function rules()
    {
        return [
            [['newPassword','confirmPassword'], 'required'],
            [['confirmPassword'], 'compare', 'compareAttribute' => 'newPassword'],
            ['newPassword', 'match', 'pattern' => '/^((?=.*\d)(?=.*[a-zA-Z])(?=.*\W).{6,20})$/i'],
        ];
    }

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function resetPassword()
    {
        $this->user->setPasswordHash($this->newPassword);
        $this->user->save();
        //Assigning so that it could be picked in notification
        $this->user->newPassword = $this->newPassword;
        //Assigning person so that another query is not hit while sending email
        $this->person = $this->user->person;
        return true;
    }

    /**
     * @inheritdoc
     */
    public static function getLabel()
    {
        return UsniAdaptor::t('users', 'Change Password');
    }
    
    /**
     * Get attribute hints.
     * return array
     */
    public function attributeHints()
    {
        return [
                    'newPassword' => UsniAdaptor::t('userhint', 'Must be of 6-20 characters. Contains atleast one special, one numeric & one alphabet.'),
                    'confirmPassword' => UsniAdaptor::t('userhint', 'Must be of 6-20 characters. Contains atleast one special, one numeric & one alphabet.')
               ];
    }
}