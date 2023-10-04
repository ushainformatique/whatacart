<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\utils;

use usni\UsniAdaptor;
use usni\library\utils\ArrayUtil;
/**
 * Utility functions related to file upload.
 * 
 * @package usni\library\utils
 */
class FileUploadUtil
{   
    /**
     * Saves file.
     * @param string $type.
     * @param array $config.
     * @return void
     */
    public static function save($type, $config = [])
    {
        $fileManagerInstance   = UsniAdaptor::app()->assetManager->getResourceManager($type, $config);
        $fileManagerInstance->save();
    }
    
    /**
     * Get encrypted file name during file upload.
     * @param string $filename File name.
     * @return string
     */
    public static function getEncryptedFileName($filename)
    {
        return UsniAdaptor::app()->assetManager->getEncryptedFileName($filename);
    }
    
    /**
     * Get no available image
     * @param array $htmlOptions
     * @return string
     */
    public static function getNoAvailableImage($htmlOptions = [])
    {
        $fileManagerInstance   = UsniAdaptor::app()->assetManager->getResourceManager('image', $htmlOptions);
        return $fileManagerInstance->getNoAvailableImage(); 
    }
    
    /**
     * Gets thumbnail image.
     * @param Model $model.
     * @param string $attribute Image attribute.
     * @param array $htmlOptions. It could contain width and height of the required image
     * @return mixed
     */
    public static function getThumbnailImage($model, $attribute, $htmlOptions = [])
    {
        $config = ArrayUtil::merge(['model' => $model, 'attribute' => $attribute], $htmlOptions);
        $fileManagerInstance   = UsniAdaptor::app()->assetManager->getResourceManager('image', $config);
        return $fileManagerInstance->getThumbnailImage();
    }
    
    /**
     * Save custom image.
     * @param Model $model
     * @param string $attribute
     * @param int $width
     * @param int $height
     * @param $targetPath string
     * @param $sourcePath string
     * @return void
     */
    public static function saveCustomImage($model, $attribute, $width, $height)
    {
        $config = ['model' => $model, 'attribute' => $attribute,
                   'thumbWidth' => $width, 'thumbHeight' => $height];
        $imageManager   = UsniAdaptor::app()->assetManager->getResourceManager('image', $config);
        $imageManager->saveSizedImage();
    }
    
    /**
     * Delete image.
     * @param \usni\library\utils\Model $model
     * @param string $attribute
     * @param int $width
     * @param int $height
     * @param bool $createThumbnail
     */
    public static function deleteImage($model, $attribute, $width, $height, $createThumbnail = true)
    {
        $config = ['model' => $model, 'attribute' => $attribute,
                   'thumbWidth' => $width, 'thumbHeight' => $height, 'createThumbnail' => $createThumbnail];
        $imageManager = UsniAdaptor::app()->assetManager->getResourceManager('image', $config);
        $imageManager->delete();
    }
    
    /**
     * Check if file exists
     * @param string $path
     * @param string $fileName
     * @param string $prefix
     * @return boolean
     */
    public static function checkIfFileExists($path, $fileName, $prefix = null)
    {
        return UsniAdaptor::app()->assetManager->checkIfFileExists($path, $fileName, $prefix);
    }
    
    /**
     * Get uploaded file path.
     * @param string $type.
     * @param array $config.
     * @return void
     */
    public static function getUploadedFilePath($type, $config = [])
    {
        $fileManagerInstance   = UsniAdaptor::app()->assetManager->getResourceManager($type, $config);
        return $fileManagerInstance->getUploadedFilePath();
    }
    
    /**
     * Delete file.
     * @param \usni\library\utils\Model $model
     * @param string $attribute
     */
    public static function deleteFile($model, $attribute)
    {
        $config         = ['model' => $model, 'attribute' => $attribute];
        $fileManager    = UsniAdaptor::app()->assetManager->getResourceManager('file', $config);
        $fileManager->delete();
    }
    
    /**
     * Get file type by extension
     * @param string $extension
     * @return string
     */
    public static function getFileTypeByExtension($extension)
    {
        $type       = null;
        $imageTypes = static::getImageExtensions();
        $fileTypes  = static::getFileExtensions();
        $videoTypes = static::getVideoExtensions();
        if(in_array($extension, $imageTypes))
        {
            $type = 'image';
        }
        elseif(in_array($extension, $videoTypes))
        {
            $type = 'video';
        }
        elseif(in_array($extension, $fileTypes))
        {
            $type = 'file';
        }
        return $type;
    }
    
    /**
     * Get image extensions
     * @return array
     */
    public static function getImageExtensions()
    {
        return ['jpg', 'png', 'gif', 'jpeg'];
    }
    
    /**
     * Get file extensions
     * @return array
     */
    public static function getFileExtensions()
    {
        return ['zip', 'doc', 'txt', 'docx', 'pdf'];
    }
    
    /**
     * Get video extensions
     * @return array
     */
    public static function getVideoExtensions()
    {
        return ['qt', '3g2', '3gp', 'f4v', 'mpeg', 'flv', 'avi', 'mp4'];
    }
    
    /**
     * Gets image.
     * @param Model $model.
     * @param string $attribute Image attribute.
     * @return mixed
     */
    public static function getImage($model, $attribute)
    {
        if($model[$attribute] == null)
        {
            return static::getNoAvailableImage();
        }
        else
        {
            return Html::img(UsniAdaptor::app()->getAssetManager()->getImageUploadUrl() . DS . $model[$attribute]);
        }
    }
}