<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\users\traits;

use usni\library\modules\users\events\UpdateUserEvent;
use usni\library\modules\auth\models\Group;
use usni\library\managers\UploadInstanceManager;
use yii\web\UploadedFile;
use usni\library\utils\FileUploadUtil;
use usni\library\modules\users\models\Address;
use usni\UsniAdaptor;
use usni\library\modules\users\dto\UserDetailViewDTO;
use usni\library\modules\auth\dao\AuthDAO;
use usni\library\modules\users\dto\UserGridViewDTO;
use usni\library\utils\ArrayUtil;
use usni\library\utils\StringUtil;
use usni\library\modules\users\models\User;
use usni\library\modules\users\events\ChangePasswordEvent;
use usni\library\modules\users\models\ChangePasswordForm;
use usni\library\modules\users\models\Person;
use yii\base\Model;
/**
 * Implement common functions related to user manager
 *
 * @package usni\library\modules\users\traits
 */
trait UserManagerTrait
{
    /**
     * Check if the model is the new record
     * @var boolean 
     */
    public $isNewRecord;
    
    /**
     * Process after update.
     * @param UpdateUserEvent $event
     */
    public function processAfterUpdate($event)
    {
        $model    = $event->model;
        $authName = $model->getAuthName();
        $authType = $model->getAuthType();
        $permissions = [$authType . '.update', $authType . '.view', $authType . '.change-password'];
        UsniAdaptor::app()->authorizationManager->addAssignments($permissions, $authName, $authType);
    }
    
    /**
     * Get groups.
     * @return array
     */
    public function getGroups()
    {
        $group                  = new Group(['type' => $this->groupCategory]);
        $group->created_by      = $this->userId;
        $accessOwnedModelsOnly  = true;
        if (UsniAdaptor::app()->authorizationManager->checkAccess($this->userId, $this->memberType . '.updateother'))
        {
            $accessOwnedModelsOnly = false;
        }
        return $group->getMultiLevelSelectOptions('name', $accessOwnedModelsOnly);
    }
    
    /**
     * @inheritdoc
     */
    public function processInputData($formDTO)
    {
        $model      = $formDTO->getModel();
        $this->isNewRecord = $model->isNewRecord;
        $person     = $formDTO->getPerson();
        $address    = $formDTO->getAddress();
        if(Model::validateMultiple([$model, $person, $address]))
        {
            $config = [
                'model' => $person,
                'attribute' => 'profile_image',
                'uploadInstanceAttribute' => 'uploadInstance',
                'type' => 'image',
                'savedAttribute' => 'savedImage',
                'fileMissingError' => UsniAdaptor::t('application', 'Please upload image'),
            ];
            $uploadInstanceManager = new UploadInstanceManager($config);
            $result = $uploadInstanceManager->processUploadInstance();
            if($result === false)
            {
                return false;
            }
            $this->beforeModelSave($person);
            if($person->save(false))
            {
                $person->uploadInstance = UploadedFile::getInstance($person, 'profile_image');
                if($person->profile_image != null)
                {
                    $config = [
                        'model' => $person,
                        'attribute' => 'profile_image',
                        'uploadInstance' => $person->uploadInstance,
                        'savedFile' => $person->savedImage
                    ];
                    FileUploadUtil::save('image', $config);
                }
                $model->person_id = $person->id;
                if($model->isNewRecord)
                {
                    $model->setPasswordHash($model->password);
                    $model->generateAuthKey();
                }
                $this->beforeModelSave($model);
                $model->save(false);
                if($address != null)
                {
                    $address->relatedmodel = 'Person';
                    $address->relatedmodel_id = $person->id;
                    $address->type = Address::TYPE_DEFAULT;
                    $this->beforeModelSave($address);
                    $address->save(false);
                }
                $model->newPassword = $model->password;
                $this->afterModelSave($model);
                return true;
            }
        }
        return false;
    }
    
    /**
     * Populate form dto based on the scenario. In case of create it would be
     * new instances and in case of update it would be populated from 
     * @param UserFormDTO $formDTO
     */
    public function populateFormDTO($formDTO)
    {
        $scenario   = $formDTO->getScenario();
        $modelClass = get_class($formDTO->getModel());
        if($scenario == 'create')
        {
            $model      = new $modelClass(['scenario' => $scenario]);
            $person     = new Person(['scenario' => $scenario]);
            $address    = new Address(['scenario' => $scenario]);
        }
        elseif($scenario == 'update')
        {
            $model = $formDTO->getModel();
            $model->scenario = $scenario;
            $person = $model->person;
            $person->scenario = $scenario;
            $address = $model->address;
            $address->scenario = $scenario;
            if($person->profile_image != null)
            {
                $person->savedImage = $person->profile_image;
            }
            $formDTO->setBrowseModels($this->getBrowseModels($modelClass));
        }
        $postData = $formDTO->getPostData();
        if(!empty($postData[UsniAdaptor::getObjectClassName($modelClass)]))
        {
            $model->load($postData);
            $person->load($postData);
            $address->load($postData);
        }
        $formDTO->setPerson($person);
        $formDTO->setAddress($address);
        $formDTO->setModel($model);
        $userGroups = $this->getGroups();
        $formDTO->setGroups($userGroups);
    }
    
    /**
     * @inheritdoc
     * @param UserGridViewDTO $gridViewDTO
     */
    public function processList($gridViewDTO)
    {
        parent::processList($gridViewDTO);
        $userGroups = $this->getGroups();
        $gridViewDTO->setGroupList($userGroups);
    }
    
    /**
     * Process login.
     * @param object $formDTO
     */
    public function processLogin($formDTO)
    {
        $model = $formDTO->getModel();
        $postData = $formDTO->getPostData();
        if(!empty($postData['LoginForm']))
        {
            $model->attributes = $postData['LoginForm'];
            if($model->validate())
            {
                if ($model->login())
                {
                    $formDTO->setIsTransactionSuccess(true);
                }
            }
            $formDTO->setModel($model);
        }
    }
    
    /**
     * Process detail
     * @param UserDetailViewDTO $detailViewDTO
     */
    public function processDetail($detailViewDTO)
    {
        parent::processDetail($detailViewDTO);
        $model = $detailViewDTO->getModel();
        $model['groups'] = $this->getGroupsById($model['id']);
        $detailViewDTO->setModel($model);
        $person = Person::find()->where('id = :id', [':id' => $model['person_id']])->asArray()->one();
        $person['fullName'] = $this->getFullName($person['firstname'], $person['lastname']);
        $detailViewDTO->setPerson($person);
        $address = Address::find()->where('relatedmodel_id = :rmid AND relatedmodel = :rm', [':rmid' => $person['id'], ':rm' => 'Person'])->asArray()
            ->one();
        $detailViewDTO->setAddress($address);
    }
    
    /**
     * Get full name for the user.
     * @return string
     */
    public function getFullName($firstname, $lastname)
    {
        if ($firstname != null && $lastname != null)
        {
            return $firstname . ' ' . $lastname;
        }
        else
        {
            return UsniAdaptor::t('application', '(not set)');
        }
    }
    
    /**
     * Get user groups.
     * 
     * @param integer $userId
     * @return string
     */
    public function getGroupsById($userId)
    {
        $groups = AuthDAO::getGroups($userId, $this->memberType);
        if(!empty($groups))
        {
            $groupNameArray = [];
            foreach ($groups as $group)
            {
                $groupNameArray[] = $group['name'];
            }
            return implode(', ', $groupNameArray);
        }
        return UsniAdaptor::t('application', '(not set)');
    }
    
    /**
     * @inheritdoc
     */
    public function processBulkEdit($formDTO)
    {
        $modelClassName = $formDTO->getModelClass();
        $selectedIdData = explode(',', $formDTO->getSelectedIds());
        $formData       = $formDTO->getPostData();
        $modelData      = (!empty($modelData = ArrayUtil::getValue($formData, UsniAdaptor::getObjectClassName($modelClassName))) ? $modelData : []);
        $personData     = (!empty($personData = ArrayUtil::getValue($formData, 'Person')) ? $personData : []);
        $addressData    = (!empty($addressData = ArrayUtil::getValue($formData, 'Address')) ? $addressData : []);
        $data           = array_merge($modelData, $personData, $addressData);
        $modelBaseName  = strtolower(StringUtil::basename($modelClassName));
        if(!empty($selectedIdData))
        {
            foreach($data as $key => $value)
            {
                foreach($selectedIdData as $id)
                {
                    if($value != null)
                    {
                        $model              = $modelClassName::findOne($id);
                        $model->scenario    = 'bulkedit';
                        if(($model['created_by'] == $this->userId && UsniAdaptor::app()->authorizationManager->checkAccess($this->userId, $modelBaseName . '.update')) ||
                            ($model['created_by'] != $this->userId && UsniAdaptor::app()->authorizationManager->checkAccess($this->userId, $modelBaseName . '.updateother')))
                        {
                            $this->updateModelAttributeWithBulkEdit($model, $key, $value);
                        }
                    }
                }
            }
        }
    }
    
    /**
     * Update model attribute with bulk edit
     * @param Model $model
     * @param string $key
     * @param string $value
     */
    public function updateModelAttributeWithBulkEdit($model, $key, $value)
    {
        $userFields     = ['status', 'timezone', 'groups'];
        $addressFields  = ['city', 'country', 'state', 'postal_code'];
        $personFields   = ['firstname', 'lastname'];
        if(in_array($key, $userFields))
        {
            if($value !== null && $value !== '')
            {
                if($key == 'groups')
                {
                    if(is_string($value) || is_int($value))
                    {
                        $value = [strval($value)];
                    }
                }
                $model->$key = $value;
                $model->save();
            }
        }
        elseif(in_array($key, $addressFields))
        {
            if(!empty($value))
            {
                $model->address->$key = $value;
                $model->address->save();
            }
        }
        elseif(in_array($key, $personFields))
        {
            if (!empty($value))
            {
                $model->person->$key = $value;
                $model->person->save();
            }
        }
    }
    
    /**
     * Process change password.
     * @param array $data
     */
    public function processChangeStatus($data)
    {
        $modelClass  = $data['modelClass'];
        $model       = $modelClass::findOne($data['id']);
        if($this->processUserAccess($model, strtolower(UsniAdaptor::getObjectClassName($modelClass)) . '.change-status'))
        {
            $model->status = $data['status'];
            $model->save(false);
            return true;
        }
        else
        {
            return false;
        }
    }
    
    /**
     * Process user access.
     * @param Model $model
     * @param string $permission
     * @return boolean
     */
    public function processUserAccess($model, $permission)
    {
        if($model['id'] != $this->userId)
        {
            if ($model['created_by'] == $this->userId)
            {
                return true;
            }
            return UsniAdaptor::app()->authorizationManager->checkAccess($this->userId, $permission);
        }
        return true;
    }
    
    /**
     * Process change password.
     * @param UserFormDTO $formDTO
     */
    public function processChangePassword($formDTO)
    {
        $modelClass     = $formDTO->getModelClassName();
        $user           = $modelClass::findOne($formDTO->getId());
        $postData       = $formDTO->getPostData();
        $isPermissible  = $this->processUserAccess($user, strtolower(UsniAdaptor::getObjectClassName($modelClass)) . '.change-passwordother');
        if($isPermissible)
        {
            $model = new ChangePasswordForm(['user' => $user]);
            if(!empty($postData))
            {
                $model->attributes = $postData;
                if($model->validate() && $model->resetPassword())
                {
                    $this->sendChangePasswordMail($user);
                    $formDTO->setIsTransactionSuccess(true);
                    //Set to null
                    $model->newPassword = null;
                    $model->confirmPassword = null;
                }
            }
            $formDTO->setModel($model);
        }
        else
        {
            $formDTO->setIsTransactionSuccess(false);
        }
    }
    
    /**
     * Send change password mail.
     * @param User $user
     */
    public function sendChangePasswordMail($user)
    {
        $event = new ChangePasswordEvent(['user' => $user]);
        $this->trigger(User::EVENT_CHANGE_PASSWORD, $event);
    }
}
