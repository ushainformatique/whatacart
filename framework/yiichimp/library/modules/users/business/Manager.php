<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\users\business;

use usni\UsniAdaptor;
use usni\library\modules\users\models\Address;
use usni\library\modules\users\dto\UserFormDTO;
use usni\library\modules\users\models\User;
use usni\library\modules\users\models\Person;
use usni\library\modules\users\services\NotificationService;
use usni\library\modules\users\dao\UserDAO;
use usni\library\utils\ArrayUtil;
use usni\library\utils\TimezoneUtil;
use usni\library\modules\users\events\UpdateUserEvent;
use usni\library\modules\users\events\CreateUserEvent;
use usni\library\modules\users\models\LatestUserSearch;
/**
 * Manager class file.
 * 
 * @package usni\library\modules\users\business
 */
class Manager extends \usni\library\business\Manager
{
    use \usni\library\modules\users\traits\UserManagerTrait;
    
    /**
     * Contain member type.
     * @var string.
     */
    public $memberType = 'user';
    
    /**
     * Contain group category.
     * @var string 
     */
    public $groupCategory = 'system';
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ['notifyService' => NotificationService::className()];
    }
    
    /**
     * inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->on(User::EVENT_AFTER_UPDATE, [$this, 'processAfterUpdate']);
    }
    
    /**
     * Process settings.
     * @param UserFormDTO $formDTO
     */
    public function processSettings($formDTO)
    {
        $postData   = $formDTO->getPostData();
        $model      = $formDTO->getModel();
        if(isset($postData))
        {
            $model->attributes = $postData;
            if($model->validate())
            {
                UsniAdaptor::app()->configManager->processInsertOrUpdateConfiguration($model, 'users');
                if(empty($model->errors))
                {
                    return true;
                }
            }
        }
        else
        {
            $model->attributes = UsniAdaptor::app()->configManager->getModuleConfiguration('users');
        }
        $formDTO->setModel($model);
    }

    /**
     * Validate email address.
     * @param string $hash
     * @param string $email
     * @return boolean
     */
    public function validateEmailAddress($hash, $email)
    {
        $tableName  = UsniAdaptor::tablePrefix() . 'user';
        $user       = UserDAO::activateUser($tableName, $hash, $email);
        if($user !== false)
        {
            $permissions = ['user.update', 'user.view', 'user.changepassword'];
            UsniAdaptor::app()->authorizationManager->addAssignments($permissions, $user['username'], 'user');
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Create super user for the system.
     * @param array $data
     * @return void
     */
    public function createSuperUser($data = [])
    {
        $user       = new User(['scenario' => 'supercreate']);
        $person     = new Person(['scenario' => 'supercreate']);
        $address    = new Address(['scenario' => 'supercreate']);

        $email      = ArrayUtil::getValue($data, 'superEmail', 'demo@xyz.com');
        $password   = ArrayUtil::getValue($data, 'superPassword', 'admin');
        $username   = ArrayUtil::getValue($data, 'superUsername', User::SUPER_USERNAME);
        $timezone   = ArrayUtil::getValue($data, 'timezone', TimezoneUtil::getCountryTimezone('IN'));
        $firstname  = ArrayUtil::getValue($data, 'firstName', 'Super');
        $lastname   = ArrayUtil::getValue($data, 'lastName', 'Admin');

        $userData       = ['username' => $username, 'timezone' => $timezone, 'status' => User::STATUS_ACTIVE, 'password' => $password];
        $personData     = ['email' => $email, 'firstname' => $firstname, 'lastname' => $lastname, 'mobilephone' => ''];
        $addressData    = ['country' => 'IN', 'state' => 'Delhi', 'address1' => '302', 'address2' => '9A/1, W.E.A, Karol Bagh', 'city' => 'New Delhi',
                           'postal_code' => 110005, 'status' => User::STATUS_ACTIVE];
        $user->attributes       = $userData;
        $user->id               = User::SUPER_USER_ID;
        $person->attributes     = $personData;
        $address->attributes    = $addressData;
        $user->setPasswordHash($password);
        $formDTO = new UserFormDTO();
        $formDTO->setModel($user);
        $formDTO->setPerson($person);
        $formDTO->setAddress($address);
        $formDTO->setScenario('supercreate');
        if ($this->processInputData($formDTO))
        {
            return $user;
        }
        else
        {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function getBrowseModels($modelClass)
    {
        return User::find()->where('id != :id', [':id' => User::SUPER_USER_ID])->orderBy(['id' => SORT_ASC])->asArray()->all();
    }
    
    /**
     * Process user edit.
     * @param object $formDTO
     */
    public function processEdit($formDTO)
    {
        $this->populateFormDTO($formDTO);
        if (!empty($formDTO->getPostData()))
        {
            $result = $this->processInputData($formDTO);
            $formDTO->setIsTransactionSuccess($result);
        }
    }
    
    /**
     * @inheritdoc
     */
    public function afterModelSave($model)
    {
        if($this->isNewRecord)
        {
            $event      = new CreateUserEvent(['user' => $model]);
            $this->trigger(User::EVENT_AFTER_INSERT, $event);
        }
        else
        {
            $event = new UpdateUserEvent(['model' => $model]);
            $this->trigger(User::EVENT_AFTER_UPDATE, $event);
        }
        return true;
    }
    
    /**
     * Process latest users
     * @param \usni\library\dto\GridViewDTO $gridViewDTO
     */
    public function processLatestUsers($gridViewDTO)
    {
        $userSearch = new LatestUserSearch();
        $gridViewDTO->setDataProvider($userSearch->search());
    }
}
