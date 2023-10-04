<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\users\models;

use usni\library\db\ActiveRecord;
use usni\library\modules\auth\web\IAuthIdentity;
use usni\UsniAdaptor;
use usni\library\modules\auth\business\AuthManager;
use usni\library\utils\ArrayUtil;

/**
 * User is the base class for table tbl_user.
 *
 * It also consist of extra attributes required to store the information in different scenarios,
 * for example $newPassword during change password scenario.
 *
 * @package usni\library\modules\users\models
 */
class User extends ActiveRecord implements IAuthIdentity
{
    use \usni\library\modules\users\traits\AuthIdentityTrait;
    
    /**
     * Misc constants.
     */
    const STATUS_PENDING    = 2;
    const SUPER_USERNAME    = 'super';
    const SUPER_USER_ID     = 1;
    
    /**
     * Notification constants
     */
    const NOTIFY_CREATEUSER        = 'createUser';
    const NOTIFY_CHANGEPASSWORD    = 'changepassword';
    const NOTIFY_FORGOTPASSWORD    = 'forgotpassword';
    
    /**
     * Change password event
     */
    const EVENT_CHANGE_PASSWORD = 'changePassword';
    
    
    /**
     * @var string 
     */
    public $groupType = 'user';

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios                  = parent::scenarios();
        $commonAttributes           = ['username','timezone', 'status', 'groups', 'type'];
        $scenarios['create']        = ArrayUtil::merge($scenarios['create'], $commonAttributes, ['password', 'confirmPassword']);
        $scenarios['update']        = $commonAttributes;
        $scenarios['supercreate']   = ArrayUtil::merge($commonAttributes, ['password']);
        $scenarios['bulkedit']      = ['timezone', 'status', 'groups'];
        return $scenarios;
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array(
            //User model fields rule.
            [['username'],                      'required'],
            ['username',                        'trim'],
            ['type',                            'required', 'except' => 'supercreate'],
            ['type',                            'default', 'value' => 'system'],
            ['username',                        'unique', 'targetClass' => get_class($this), 'on' => 'create'],
            ['username', 'unique', 'targetClass' => get_class($this), 'filter' => ['!=', 'id', $this->id], 'on' => 'update'],
            ['username',                        'match', 'pattern' => '/^[A-Z0-9._]+$/i'],
            //@see http://www.zorched.net/2009/05/08/password-strength-validation-with-regular-expressions/
            ['password',                        'match', 'pattern' => '/^((?=.*\d)(?=.*[a-zA-Z])(?=.*\W).{6,20})$/i', 'except' => 'supercreate'],
            ['password',                        'required', 'on' => ['create']],
            ['timezone',                        'required', 'except' => ['default', 'bulkedit']],
            ['confirmPassword',                 'required', 'on' => ['create']],
            ['status',                          'default', 'value' => User::STATUS_PENDING],
            ['groups',                          'safe'],
            [['confirmPassword'], 'compare', 'compareAttribute' => 'password', 'on' => 'create']
        );
    }

    /**
     * @inheritdoc
     */
    public static function getLabel($n = 1)
    {
        return ($n == 1) ? UsniAdaptor::t('users', 'User') : UsniAdaptor::t('users', 'Users');
    }

   /**
     * Gets auth type.
     * @return string
     */
    public function getAuthType()
    {
        return AuthManager::TYPE_USER;
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if(parent::beforeDelete())
        {
            $this->processBeforeDelete();
            return true;
        }
        else
        {
            return false;
        }
    }
}