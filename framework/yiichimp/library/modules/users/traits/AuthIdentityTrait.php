<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\users\traits;

use usni\UsniAdaptor;
use usni\library\modules\auth\dao\AuthDAO;
use usni\library\modules\auth\models\GroupMember;
use usni\library\utils\ArrayUtil;
use usni\library\modules\users\utils\UserUtil;
use usni\library\modules\users\models\Person;
use usni\library\modules\users\models\Address;
/**
 * Implement common functions related to auth identity
 * 
 * @package usni\library\modules\users\traits
 */
trait AuthIdentityTrait
{
    /**
     * Store password during change password or forgot password.
     * @var string
     */
    public $newPassword;
    /**
     * Store confirm password which matches the password entered by user.
     * @var string
     */
    public $confirmPassword;
    /**
     * Store password during user creation.
     * @var string
     */
    public $password;
    /**
     * Contain groups assigned to user when creating or updating the user
     * @var array
     */
    public $groups = [];
    
    /**
     * Gets auth name.
     * @return string
     */
    public function getAuthName()
    {
        return $this->username;
    }
    
    /**
     * Get address for the customer.
     * @return ActiveQuery
     */
    public function getAddress()
    {
        //Read it as select * from address, person where address.relatedmodel_id = person.id  AND person.id = customer.person_id
        //Thus when via is used second param in the link correspond to via column in the relation.
        return $this->hasOne(Address::className(), ['relatedmodel_id' => 'id'])
                    ->where('relatedmodel = :rm AND type = :type', [':rm' => 'Person', ':type' => Address::TYPE_DEFAULT])
                    ->via('person');
    }
    
    /**
     * Get person for the user.
     * @return ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Person::className(), ['id' => 'person_id']);
    }
    
    /**
     * Get auth key.
     * @return string
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Gets identity
     * @return integer
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * Validates auth key.
     * @param string $authKey
     * @return boolean
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return UsniAdaptor::app()->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @return void
     */
    public function setPasswordHash($password)
    {
        $this->password_hash = UsniAdaptor::app()->security->generatePasswordHash($password);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = UsniAdaptor::app()->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = UsniAdaptor::app()->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) 
        {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        $expire = UsniAdaptor::app()->configManager->getValue('users', 'passwordTokenExpiry');
        if($expire === null)
        {
            return true;
        }
        if (empty($token)) 
        {
            return false;
        }
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }
    
    /**
     * After find populate the groups
     * @return void
     */
    public function afterFind()
    {
        parent::afterFind();
        $groups     = AuthDAO::getGroups($this->id, $this->groupType);
        $groupIds   = [];
        foreach ($groups as $group)
        {
            $groupIds[] = $group['id'];
        }
        $this->groups = $groupIds;
    }
    
    /**
     * inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $this->saveGroups($this->groupType);
    }
    
    /**
     * Gets name for user.
     * @return string
     */
    public function getName()
    {
        $person = $this->getPerson()->one();
        return $person->getFullName();
    }
    
    /**
     * Process before delete
     */
    public function processBeforeDelete()
    {
        AuthDAO::deleteGroupMembers($this->id, $this->groupType);
        $this->address->delete();
        $this->person->delete();
    }
    
    /**
     * Saves user groups.
     * @param string $type
     * @return void
     */
    public function saveGroups($type)
    {
        AuthDAO::deleteGroupMembers($this->id, $type);
        if(!empty($this->groups))
        {
            if(is_array($this->groups))
            {
                foreach($this->groups as $group)
                {
                    $this->processSaveGroups($type, $group);
                }
            }
            else
            {
                $this->processSaveGroups($type, $this->groups);
            }
        }
    }
    
    /**
     * Process save groups.
     * @param type $type
     * @param int $group
     */
    public function processSaveGroups($type, $group)
    {
        $groupMember = new GroupMember(['scenario' => 'create']);
        $groupMember->member_type = $type;
        $groupMember->member_id = $this->id;
        $groupMember->group_id = $group;
        $groupMember->save();
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        if($this->checkIfExtendedConfigExists())
        {
            $configInstance = $this->getExtendedConfigClassInstance();
            $labels         = $configInstance->attributeLabels();
        }
        else
        {
            $labels = ArrayUtil::merge(parent::attributeLabels(), UserUtil::getUserLabels(), [
                'id'                => UsniAdaptor::t('application', 'Id'),
                'newPassword'       => UsniAdaptor::t('users', 'New Password'),
                'last_login'        => UsniAdaptor::t('users', 'Last Login'),
                'login_ip'          => UsniAdaptor::t('users', 'Last Login IP'),
                'person_id'         => UsniAdaptor::t('users', 'Person'),
                'email'             => UsniAdaptor::t('users', 'Email'),
                'groups'            => UsniAdaptor::t('auth', 'Groups'),
            ]);
        }
        return parent::getTranslatedAttributeLabels($labels);
    }
    
    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        if($this->checkIfExtendedConfigExists())
        {
            $configInstance = $this->getExtendedConfigClassInstance();
            return $configInstance->attributeHints();
        }
        else
        {
            return array(
                 'username'    => UsniAdaptor::t('userhint', 'Minimum 3 characters. Spaces not allowed. Allowed characters [a-zA-Z0-9._]'),
                 'email'       => UsniAdaptor::t('userhint', 'Letters, numbers & periods are allowed with a mail server name. eg test@yahoo.com'),
                 'password'    => UsniAdaptor::t('userhint', 'Must be of 6-20 characters. Contains atleast one special, one numeric & one alphabet.'),
                 'newPassword' => UsniAdaptor::t('userhint', 'Must be of 6-20 characters. Contains atleast one special, one numeric & one alphabet.'),
                 'confirmPassword' => UsniAdaptor::t('userhint', 'Must be of 6-20 characters. Contains atleast one special, one numeric & one alphabet.')
            );
        }
    }
}
