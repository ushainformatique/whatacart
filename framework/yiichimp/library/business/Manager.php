<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\business;

use usni\UsniAdaptor;
use usni\library\dto\DetailViewDTO;
use usni\library\dto\BulkEditFormDTO;
use usni\library\db\ActiveRecord;
use usni\library\modules\users\dao\UserDAO;
use usni\library\dto\FormDTO;
use usni\library\dto\GridViewDTO;
use usni\library\utils\StringUtil;
use yii\base\InvalidParamException;
use usni\library\db\TranslatableActiveRecord;
use usni\library\utils\ArrayUtil;
/**
 * Manager class file. This class acts as the base manager class for the business layer.
 * 
 * @package usni\library\business
 */
class Manager extends \yii\base\Component
{
    /**
     * Language selected by the user. It would be used in case of translated models for e.g. Group.
     * @var string 
     */
    public $language;
    
    /**
     * User id of the logged in identity
     * @var integer
     */
    public $userId;
    
    /**
     * @var string 
     */
    public $modelClass;


    /**
     * inheritdoc
     */
    public function init()
    {
        if($this->language == null)
        {
            if(UsniAdaptor::app()->isInstalled())
            {
                $this->language = UsniAdaptor::app()->languageManager->selectedLanguage;
            }
            else
            {
                $this->language = UsniAdaptor::app()->language;
            }
        }
        if($this->userId == null)
        {
            if(UsniAdaptor::app()->isInstalled())
            {
                $this->userId   = UsniAdaptor::app()->user->getId();
            }
            else
            {
                $this->userId   = 0;
            }
        }
    }
    
    /**
     * Get instance of the class
     * @param array $config
     * @return get_called_class() the created object
     */
    public static function getInstance($config = [])
    {
        $class = get_called_class();
        return new $class($config);
    }
    
    /**
     * Process edit.
     * @param FormDTO $formDTO
     */
    public function processEdit($formDTO) 
    {
        $model      = $formDTO->getModel();
        $scenario   = $model->scenario;
        $postData   = $formDTO->getPostData();
        if (!empty($postData))
        {
            $this->beforeAssigningPostData($model);
            $model->load($postData);
            $result = $this->processInputData($model);
            $formDTO->setModel($model);
            $formDTO->setIsTransactionSuccess($result);
        }
        if($scenario != 'create')
        {
            $modelClass = get_class($formDTO->getModel());
            $formDTO->setBrowseModels($this->getBrowseModels($modelClass));
        }
        elseif (!empty($postData))
        {
            if($model instanceof TranslatableActiveRecord && empty($model->errors) && $model->scenario == 'create')
            {
                $model->saveTranslatedModels();
            }
        }
    }
    
    /**
     * Perform changes to the model before assigning the data from post array.
     * @param ActiveRecord $model
     * @return void
     */
    public function beforeAssigningPostData($model)
    {

    }
    
    /**
     * Get the list of models for browse
     * @param string $modelClass
     * @return array
     */
    public function getBrowseModels($modelClass)
    {
        return $modelClass::find()->orderBy(['id' => SORT_ASC])->asArray()->all();
    }
    
    /**
     * Process input data.
     * 
     * @param ActiveRecord $model
     * @throws \yii\db\Exception
     * @throws Throwable
     */
    public function processInputData($model)
    {
        if($this->beforeModelSave($model))
        {
            $transaction = UsniAdaptor::db()->beginTransaction();
            try
            {
                if ($model->save())
                {
                    if ($this->afterModelSave($model))
                    {
                        $transaction->commit();
                        return true;
                    }
                    else
                    {
                        $transaction->rollback();
                        \Yii::info("After model saved failed");
                        return false;
                    }
                }
                else
                {
                    \Yii::info("Model saved failed");
                    $transaction->rollback();
                    return false;
                }
            }
            catch (\Exception $e)
            {
                $transaction->rollback();
                throw $e;
            }
            //Php 7.0
            catch(\Throwable $e) 
            {
                $transaction->rollBack();
                throw $e;
            }
        }
        return false;    
    }
    
    /**
     * Perform changes to the model before saving it.
     * If this is overridden in the extended class than make a call like
     * if(parent::beforeModelSave($model)
     * {
     *      code here..
     *      return true;
     * }
     * return false;
     * @param ActiveRecord $model
     * @return void
     */
    public function beforeModelSave($model)
    {
        return true;
    }

    /**
     * Perform changes after saving the model.
     * @param ActiveRecord $model
     * @return boolean
     */
    public function afterModelSave($model)
    {
        return true;
    }
    
    /**
     * Populate metadata related to author and time in DTO
     * @param DetailViewDTO $detailViewDTO
     */
    public function populateMetadata($detailViewDTO)
    {
        //Call user DAO
        $model      = $detailViewDTO->getModel();
        if(ArrayUtil::getValue($model, 'created_by', false) !== false)
        {
            $createdBy  = UserDAO::getById($model['created_by']);
            $detailViewDTO->setCreatedBy($createdBy);
        }
        if(ArrayUtil::getValue($model, 'modified_by', false) !== false)
        {
            $modifiedBy = UserDAO::getById($model['modified_by']);
            $detailViewDTO->setModifiedBy($modifiedBy);
        }
    }
    
    /**
     * Process bulk edit update.
     * @param BulkEditFormDTO $formDTO
     */
    public function processBulkEdit($formDTO)
    {
        $selectedIdData = explode(',', $formDTO->getSelectedIds());
        if($this->modelClass == null)
        {
            $this->modelClass = $formDTO->getModelClass();
        }
        $modelClassName = $this->modelClass;
        $postData       = $formDTO->getPostData();
        $modelBaseName  = strtolower(StringUtil::basename($modelClassName));
        $formData       = ArrayUtil::getValue($postData, StringUtil::basename($modelClassName));
        if(!empty($selectedIdData))
        {
            foreach ($formData as $key => $value)
            {
                foreach ($selectedIdData as $id)
                {
                    if($value != null)
                    {
                        //Check if allowed to update
                        $model  = $modelClassName::findOne($id);
                        if(isset($model['created_by']))
                        {
                            if(($model['created_by'] == $this->userId && UsniAdaptor::app()->authorizationManager->checkAccess($this->userId, $modelBaseName . '.update')) ||
                                    ($model['created_by'] != $this->userId && UsniAdaptor::app()->authorizationManager->checkAccess($this->userId, $modelBaseName . '.updateother')))
                            {
                                $this->updateModelAttributeWithBulkEdit($model, $key, $value);
                            }
                        }
                        else
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
     * @param string $model
     * @param string $key
     * @param string $value
     */
    public function updateModelAttributeWithBulkEdit($model, $key, $value)
    {
        $model->scenario    = 'bulkedit';
        $model->$key        = $value;
        $model->save();
    }
    
    /**
     * Process bulk delete.
     * @param GridViewDTO $gridViewDTO
     */
    public function processBulkDelete($gridViewDTO)
    {
        $modelClass             = $gridViewDTO->getModelClass();
        $selectedItems          = $gridViewDTO->getSelectedIdsForBulkDelete();
        $permissionPrefix       = $this->getPermissionPrefix($modelClass);
        foreach ($selectedItems as $item)
        {
            $model = $modelClass::findOne(intval($item));
            //Check if allowed to delete
            if(isset($model['created_by']))
            {
                if(($model['created_by'] == $this->userId && UsniAdaptor::app()->authorizationManager->checkAccess($this->userId, $permissionPrefix . '.delete')) ||
                        ($model['created_by'] != $this->userId && UsniAdaptor::app()->authorizationManager->checkAccess($this->userId, $permissionPrefix . '.deleteother')))
                {
                    $this->deleteModel($model);
                }
            }
            else
            {
                $this->deleteModel($model);
            }
        }
    }
    
    /**
     * Loads model.
     * @param string  $modelClass Model class name.
     * @param integer $id         ID of the model to be loaded.
     * @return Array
     * @throws exception InvalidParamException.
     */
    public function loadModel($modelClass, $id)
    {
        $model      = $modelClass::find()->where('id = :id', [':id' => $id])->asArray()->one();
        if ($model === null)
        {
            throw new InvalidParamException("Id is not valid: $id");
        }
        return $model;
    }
    
    /**
     * Deletes model
     * @param ActiveRecord $model
     * @return int|false
     * @throws \yii\db\Exception
     */
    public function deleteModel($model)
    {
        try
        {
            return $model->delete();
        }
        catch (\yii\db\Exception $ex)
        {
            throw $ex;
        }
    }
    
    /**
     * Process list.
     * @param GridViewDTO $gridViewDTO
     */
    public function processList($gridViewDTO) 
    {
        $searchModel  = $gridViewDTO->getSearchModel();
        $searchModel->load($gridViewDTO->getQueryParams());
        $gridViewDTO->setSearchModel($searchModel);
        $dataProvider = $searchModel->search();
        $gridViewDTO->setDataProvider($dataProvider);
    }
    
    /**
     * Process detail
     * @param DetailViewDTO $detailViewDTO
     */
    public function processDetail($detailViewDTO)
    {
        $modelClass         = $detailViewDTO->getModelClass();
        $model              = $this->loadModel($modelClass, $detailViewDTO->getId());
        $isPermissible      = $this->processDetailAccess($detailViewDTO, $model);
        if(!$isPermissible)
        {
            return false;
        }
        $detailViewDTO->setModel($model);
        $this->populateMetadata($detailViewDTO);
        $detailViewDTO->setBrowseModels($this->getBrowseModels($modelClass));
    }
    
    /**
     * Process detail access
     * @param DetailViewDTO $detailViewDTO
     * @param array $model
     */
    public function processDetailAccess($detailViewDTO, $model)
    {
        $modelClass         = $detailViewDTO->getModelClass();
        $isPermissible      = true;
        $permissionPrefix   = $this->getPermissionPrefix($modelClass);
        if(ArrayUtil::getValue($model, 'created_by', false) !== false)
        {
            if($this->userId != $model['created_by'])
            {
                $isPermissible  = UsniAdaptor::app()->authorizationManager->checkAccess($this->userId, $permissionPrefix . '.viewother');
            }
        }
        return $isPermissible;
    }
    
    /**
     * Get permission prefix.
     * @param string $modelClass
     * @return string
     */
    public function getPermissionPrefix($modelClass)
    {
        return strtolower(StringUtil::basename($modelClass));
    }
}
