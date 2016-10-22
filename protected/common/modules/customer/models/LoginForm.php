<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\models;

use customer\models\Customer;
/**
 * LoginForm class file.
 *
 * @package customer\models
 */
class LoginForm extends \usni\library\modules\users\models\LoginForm
{
    /**
     * Finds user by [[username]]
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false)
        {
            $this->_user = Customer::find()->where('username = :uName', [':uName' => $this->username])->one();
        }
        return $this->_user;
    }
}