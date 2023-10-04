<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\web;

use usni\library\utils\FileUtil;
use usni\UsniAdaptor;
use yii\web\UploadedFile;
/**
 * BaseFileManager class file
 * 
 * @package usni\library\web
 */
class BaseFileManager extends \yii\base\Component
{
    /**
     * Model associated to the FileManager.
     * @var Model
     */
    public $model;
    
    /**
     * Attribute associated with the FileManager.
     * @var string 
     */
    public $attribute;
    
    /**
     * Instance of uploadedFile.
     * @var UploadedFile
     */
    public $uploadInstance;
    
    /**
     * Saved image.
     * @var string 
     */
    public $savedFile;
    
    /**
     * Upload path
     * @var string 
     */
    public $uploadPath;
    
    /**
     * Get upload url
     * @var string 
     */
    public $uploadUrl;
 
    /**
     * Get type of file.
     * @return string
     * @throws \usni\library\exceptions\MethodNotImplementedException
     */
    public static function getType()
    {
        throw new \usni\library\exceptions\MethodNotImplementedException();
    }
    
    /**
     * Saves file.
     * @param boolean $deleteTempFile
     * @return void
     */
    public function save($deleteTempFile = true)
    {
        $fileUploadPath  = $this->uploadPath;
        $file            = $fileUploadPath . DS . $this->savedFile;
        if ($this->model->{$this->attribute} != null)
        {
            //Take care when existing image is unlinked on uploading new image
            if ($this->uploadInstance != null && $this->savedFile != null)
            {
                if(file_exists($file))
                {
                    unlink($file);
                }
            }

            $file = $fileUploadPath . DS . $this->model->{$this->attribute};
            if ($this->uploadInstance != null)
            {
                $this->uploadInstance->saveAs($file, $deleteTempFile);
            }
        }
    }
    
    /**
     * Get file uploaded path
     * @return string
     */
    public function getUploadedFilePath()
    {
        if ($this->model->{$this->attribute} != null)
        {
            return $this->uploadPath . DS . $this->model->{$this->attribute};
        }
        return null;
    }
    
    /**
     * Get file uploaded url
     * @return string
     */
    public function getUploadedFileUrl()
    {
        if ($this->model->{$this->attribute} != null)
        {
            return $this->uploadUrl . '/' . $this->model->{$this->attribute};
        }
        return null;
    }
    
    /**
     * Download the file.
     * @param string $fileName
     * @return void
     */
    public function download($fileName)
    {
        $path       = $this->uploadPath;
        $filePath   = FileUtil::normalizePath($path . DS . $fileName);
        if(file_exists($filePath) && is_file($filePath))
        {
            $filePath = str_replace('\\', '/', $filePath);
            UsniAdaptor::app()->response->sendFile($filePath)->send();
        }
    }
}