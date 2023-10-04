<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\web;

use usni\UsniAdaptor;
use usni\library\utils\FileUtil;
use usni\library\utils\StringUtil;
/**
 * AssetManager class file. It would add properties related to uploading files, images and video
 * assets in the application.
 * 
 * @package usni\library\web
 */
class AssetManager extends \yii\web\AssetManager
{
    /**
     * Path for the resources
     * @var string 
     */
    public $resourcesPath;
    /**
     * File upload path for the application.
     * @var string
     */
    public $fileUploadPath;
    /**
     * Image upload path for the application.
     * @var string
     */
    public $imageUploadPath;
    /**
     * Thumbnail upload path for the application.
     * @var string
     */
    public $thumbUploadPath;
    /**
     * Video upload path for the application.
     * @var string
     */
    public $videoUploadPath;
    
    /**
     * Image manager class
     * @var string 
     */
    public $imageManagerClass;
    
    /**
     * File manager class
     * @var string 
     */
    public $fileManagerClass;
    
    /**
     * Video manager class
     * @var string 
     */
    public $videoManagerClass;

    /**
     * Override so that asset directory is created.
     */
    public function init()
    {
        $basePath = UsniAdaptor::getAlias($this->basePath);
        FileUtil::createDirectory($basePath, 0777);
        FileUtil::createDirectory($this->resourcesPath, 0777);
        FileUtil::createDirectory($this->fileUploadPath, 0777);
        FileUtil::createDirectory($this->imageUploadPath, 0777);
        FileUtil::createDirectory($this->thumbUploadPath, 0777);
        FileUtil::createDirectory($this->videoUploadPath, 0777);
        parent::init();
    }

    /**
     * Gets file upload url.
     * @return string
     */
    public function getFileUploadUrl()
    {
        $frontUrl = UsniAdaptor::app()->getFrontUrl();
        $route    = str_replace(APPLICATION_PATH, '', $this->fileUploadPath);
        return StringUtil::replaceBackSlashByForwardSlash($frontUrl . $route);
    }

    /**
     * Gets image upload url.
     * @return string
     */
    public function getImageUploadUrl()
    {
        $frontUrl = UsniAdaptor::app()->getFrontUrl();
        $route    = str_replace(APPLICATION_PATH, '', $this->imageUploadPath);
        return StringUtil::replaceBackSlashByForwardSlash($frontUrl . $route);
    }

    /**
     * Gets thumbnail upload url.
     * @return string
     */
    public function getThumbnailUploadUrl()
    {
        $frontUrl = UsniAdaptor::app()->getFrontUrl();
        $route    = str_replace(APPLICATION_PATH, '', $this->thumbUploadPath);
        return StringUtil::replaceBackSlashByForwardSlash($frontUrl . $route);
    }
    
    /**
     * Get resource manager instance
     * @param string $type
     * @param array $config
     * @return \usni\library\components\BaseFileManager
     */
    public function getResourceManager($type, $config = [])
    {
        if($type == 'image')
        {
            $imageManagerClass = $this->imageManagerClass;
            return new $imageManagerClass($config);
        }
        elseif($type == 'file')
        {
            $fileManagerClass = $this->fileManagerClass;
            return new $fileManagerClass($config);
        }
        elseif($type == 'video')
        {
            $videoManagerClass = $this->videoManagerClass;
            return new $videoManagerClass($config);
        }
    }
    
    /**
     * Get encrypted file name during file upload.
     * @param string $filename File name.
     * @return string
     */
    public function getEncryptedFileName($filename)
    {
        return StringUtil::getRandomString(10) . $filename;
    }
    
    /**
     * Check if file exists
     * @param string $path
     * @param string $fileName
     * @param string $prefix
     * @return boolean
     */
    public function checkIfFileExists($path, $fileName, $prefix = null)
    {
        $filePath = StringUtil::replaceBackSlashByForwardSlash($path . DS . $prefix . $fileName);
        if(file_exists($filePath) && is_file($filePath))
        {
            return true;
        }
        return false;
    }
}