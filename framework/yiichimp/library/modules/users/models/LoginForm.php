<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\users\models;

use usni\UsniAdaptor;
use usni\library\modules\users\models\User;
/**
 * LoginForm is the data structure for keeping user login form data.
 *
 * @package usni\library\modules\users\models
 */
class LoginForm extends \yii\base\Model
{
    const ERROR_ACCOUNT_INACTIVE = 3;
    /**
     * Store username for LoginForm model.
     * @var string
     */
    public $username;

    /**
     * Store password for LoginForm model.
     * @var Encrypted string
     */
    public $password;

    /**
     * Store status of Remember me.
     * @var integer
     */
    public $rememberMe = true;

    /**
     * User associated to form.
     * @var User
     */
    protected $_user = false;

    /**
     * Declares the validation rules. The rules state that username and password are required, and password needs to be authenticated.
     * @return array
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by authenticate
            ['password', 'authenticate'],
        ];
    }

    /**
     * Declares attribute labels.
     * @return array
     */
    public function attributeLabels()
    {
        return [
                    'username' => UsniAdaptor::t('users', 'Username'),
                    'password' => UsniAdaptor::t('users', 'Password'),
                    'rememberMe' => UsniAdaptor::t('users', 'Remember me'),
               ];
    }

    /**
     * Authenticates the password. This is the 'authenticate' validator as declared in rules().
     * @param string $attribute Attribute having user attribute related to login.
     * @param array  $params
     * @return void
     */
    public function authenticate($attribute, $params)
    {
        if (!$this->hasErrors())
        {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password))
            {
                $this->addError($attribute, UsniAdaptor::t('users', 'The credentials passed are not valid.'));
            }
            elseif($user->status != User::STATUS_ACTIVE)
            {
                $this->addError($attribute, UsniAdaptor::t('users', 'Your account is not active. Kindly contact system admin.'));
            }
        }
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login()
    {
        if ($this->validate())
        {
            return UsniAdaptor::app()->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        else
        {
            return false;
        }
    }

    /**
     * Get attribute hints.
     * @return array
     */
    public function attributeHints()
    {
        return [
                    'username'  => UsniAdaptor::t('userhint', 'Minimum 3 characters. Spaces not allowed. Allowed characters [a-zA-Z0-9._]'),
                    'email'     => UsniAdaptor::t('userhint', 'Letters, numbers & periods are allowed with a mail server name. eg test@yahoo.com'),
                    'password'  => UsniAdaptor::t('userhint', 'Must be of 6-20 characters. Contains atleast one special, one numeric & one alphabet. This is not applicable for super user.')
               ];
    }

    /**
     * Finds user by [[username]]
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false)
        {
            $this->_user = User::find()->where('username = :uName', [':uName' => $this->username])->one();
        }
        return $this->_user;
    }
}
