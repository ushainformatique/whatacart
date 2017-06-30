<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\business;

use yii\web\UploadedFile;
use usni\library\utils\FileUploadUtil;
use usni\UsniAdaptor;
use usni\library\managers\UploadInstanceManager;
use products\dao\DownloadDAO;
use yii\base\InvalidParamException;
/**
 * Implements functionality related to product download.
 *
 * @package products\business
 */
class DownloadManager extends \usni\library\business\Manager
{   
    /**
     * inheritdoc
     */
    public function beforeAssigningPostData($model)
    {
        $model->savedFile = $model->file;
    }
    
    /**
     * inheritdoc
     */
    public function beforeModelSave($model)
    {
        if(parent::beforeModelSave($model))
        {
            $isValid    = true;
            $instance   = UploadedFile::getInstance($model, 'file');
            if($instance != null)
            {
                $extension  = $instance->getExtension();
                $fileType   = FileUploadUtil::getFileTypeByExtension($extension);
                $model->type    = $fileType;
            }
            else
            {
                $fileType = $model->type;
            }
            $config     = [
                                'model'             => $model,
                                'attribute'         => 'file',
                                'uploadInstanceAttribute' => 'uploadInstance',
                                'type'              => $fileType,
                                'savedAttribute'    => 'savedFile',
                                'fileMissingError'  => UsniAdaptor::t('application', 'Please upload file'),
                            ];
            $uploadInstanceManager = new UploadInstanceManager($config);
            $result = $uploadInstanceManager->processUploadInstance();
            if($result === false)
            {
                $isValid = false;
            }
            //Add size as well
            if($instance != null)
            {
                $model->size = $model->uploadInstance->size;
            }
            return $isValid;
        }
        return false;
    }
    
    /**
     * inheritdoc
     */
    public function afterModelSave($model)
    {
        if($model->uploadInstance != null)
        {
            $fileType   = FileUploadUtil::getFileTypeByExtension($model->uploadInstance->getExtension());
            if($model->file != '')
            {
                $config = [
                            'model'             => $model, 
                            'attribute'         => 'file', 
                            'uploadInstance'    => $model->uploadInstance, 
                            'savedFile'         => $model->savedFile
                          ];
                FileUploadUtil::save($fileType, $config);
            }
        }
        return true;
    }
    
    /**
     * inheritdoc
     */
    public function getBrowseModels($modelClass)
    {
        return DownloadDAO::getAll($this->language);
    }
    
    /**
     * inheritdoc
     */
    public function loadModel($modelClass, $id)
    {
        $model  = DownloadDAO::getById($id, $this->language);
        if ($model === null)
        {
            throw new InvalidParamException("Id is not valid: $id");
        }
        return $model;
    }
    
    /**
     * Process download.
     * @param integer $id
     */
    public function processDownload($id)
    {
        $download   = DownloadDAO::getById($id, $this->language);
        $fm         = UsniAdaptor::app()->assetManager->getResourceManager($download['type'], ['model' => (object)$download, 'attribute' => 'file']);
        if(YII_ENV != 'dev')
        {
            $fm->getUploadedFilePath();
        }
        $fm->download($download['file']);
    }
    
    /**
     * inheritdoc
     */
    public function getPermissionPrefix($modelClass)
    {
        return 'product';
    }
}
