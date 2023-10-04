<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\managers;

use usni\library\utils\FileUploadUtil;
use usni\UsniAdaptor;
use yii\web\UploadedFile;
/**
 * Class handling the management of upload instance
 * 
 * @package usni\library\managers
 * @example 
 * $config = [
 *              'model' => $model,
 *              'attribute' => 'image',
 *              'uploadInstanceAttribute' => 'uploadInstance',
 *              'type'      => 'image',
 *              'savedAttribute' => 'savedImage',
 *              'fileMissingError' => UsniAdaptor::t('application', 'Please upload image')
 *          ];
 *          $uploadInstanceManager = new UploadInstanceManager($config);
 *          $result = $uploadInstanceManager->processUploadInstance();
 *          if($result === false)
 *          {
 *              return false;
 *          }
 */
class UploadInstanceManager extends \yii\base\Component
{
    /**
     * Upload instance attribute
     * @var string 
     */
    public $uploadInstanceAttribute;
    
    /**
     * Attribute mapped to upload instance attribute
     * @var string 
     */
    public $attribute;
    
    /**
     * Model object
     * @var Model 
     */
    public $model;
    
    /**
     * Attribute in which saved file name is stored
     * @var string 
     */
    public $savedAttribute;
    
    /**
     * Type of file
     * @var string 
     */
    public $type;
    
    /**
     * Error when file is missing
     * @var string 
     */
    public $fileMissingError;
    
    /**
     * Check if attribute is required or not
     * @var boolean 
     */
    public $required = false;
    
    /**
     * Process upload instance.
     * @return boolean
     */
    public function processUploadInstance()
    {
        $uploadInstanceAttribute = $this->uploadInstanceAttribute;
        $savedAttribute          = $this->savedAttribute;
        $attribute               = $this->attribute;
        $this->model->$uploadInstanceAttribute = UploadedFile::getInstance($this->model, $attribute);
        if ($this->model->$uploadInstanceAttribute != null)
        {
            $isValid = $this->validateUploadInstance();
            if($isValid === false)
            {
                return false;
            }
            $this->model->$attribute = $this->getEncryptedFileName();
        }
        else
        {
            $ifFileExists = $this->checkIfFileExists();
            if($ifFileExists)
            {
                $this->model->$attribute = $this->model->$savedAttribute;
            }
            else
            {
                if($this->required)
                {
                    $this->model->addError($attribute, $this->fileMissingError);
                    return false;
                }
            }
        }
        return true;
    }
    
    /**
     * Check if file exists
     * @return boolean
     */
    public function checkIfFileExists()
    {
        $savedAttribute = $this->savedAttribute;
        $uploadPath     = $this->getUploadPath();
        return FileUploadUtil::checkIfFileExists($uploadPath, $this->model->$savedAttribute);
    }
    
    /**
     * Get upload path
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getUploadPath()
    {
        $type = $this->type;
        if($type == 'file')
        {
            return UsniAdaptor::app()->assetManager->fileUploadPath;
        }
        elseif($type == 'image')
        {
            return UsniAdaptor::app()->assetManager->imageUploadPath;
        }
        elseif($type == 'video')
        {
            return UsniAdaptor::app()->assetManager->videoUploadPath;
        }
        throw new \yii\base\InvalidConfigException();
    }
    
    /**
     * Validate upload instance.
     * @return boolean
     */
    public function validateUploadInstance()
    {
        $uploadInstanceAttribute = $this->uploadInstanceAttribute;
        //Set second arguement as false so that errors are not cleared
        if($this->model->validate([$uploadInstanceAttribute], false) === false)
        {
            $errors = $this->model->getErrors($uploadInstanceAttribute);
            $this->model->clearErrors($uploadInstanceAttribute);
            foreach($errors as $attribute => $attributeError)
            {
                $this->model->addError($this->attribute, $attributeError);
            }
            return false;
        }
        return true;
    }
    
    /**
     * Get encrypted file name
     * @return string
     */
    public function getEncryptedFileName()
    {
        $uploadInstanceAttribute = $this->uploadInstanceAttribute;
        return FileUploadUtil::getEncryptedFileName($this->model->$uploadInstanceAttribute->name);
    }
}