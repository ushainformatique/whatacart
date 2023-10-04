<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\web;

use yii\imagine\Image;
use usni\UsniAdaptor;
use usni\library\utils\FileUtil;
use usni\library\utils\Html;
use usni\library\utils\StringUtil;
use usni\library\utils\ArrayUtil;
/**
 * ImageManager class file
 * 
 * @package usni\library\web
 */
class ImageManager extends BaseFileManager
{
    /**
     * Create thumbnail
     * @var boolean 
     */
    public $createThumbnail     = false;
    /**
     * Default thumbnail width
     * @var int
     */
    public $defaultThumbWidth   = 150;
    /**
     * Default thumbnail height
     * @var int
     */
    public $defaultThumbHeight  = 150;
    /**
     * Thumbnail width
     * @var int 
     */
    public $thumbWidth;
    /**
     * Thumbnail height
     * @var int 
     */
    public $thumbHeight;
    
    /**
     * Thumbnail upload path
     * @var string 
     */
    public $thumbnailUploadPath;
    
    /**
     * Thumbnail upload url
     * @var string 
     */
    public $thumbnailUploadUrl;
    
    /**
     * Class for the image
     * @var string 
     */
    public $cssClass = 'img-responsive';
    
    /**
     * No available image name
     * @var string
     */
    public $noAvailableImageName = 'img_not_available.png';
    
    /**
     * No available image path
     * @var string
     */
    public $noAvailableImagePath = '@usni/library/assets/images';
    
    /**
     * @inheritdoc
     */
    public function __construct($config = array())
    {
        parent::__construct($config);
        if($this->thumbWidth == null)
        {
            $this->thumbWidth = $this->defaultThumbWidth;
        }
        if($this->thumbHeight == null)
        {
            $this->thumbHeight = $this->defaultThumbHeight;
        }
        $this->uploadPath = UsniAdaptor::app()->assetManager->imageUploadPath;
        $this->thumbnailUploadUrl = UsniAdaptor::app()->assetManager->getThumbnailUploadUrl();
        $this->uploadUrl = UsniAdaptor::app()->assetManager->getImageUploadUrl();
        $this->thumbnailUploadPath = UsniAdaptor::app()->assetManager->thumbUploadPath;
        if(is_array($this->model))
        {
            $this->model = (object)$this->model;
        }
    }
    
    /**
     * @inheritdoc
     */
    public function save($deleteTempFile = true)
    {
        parent::save($deleteTempFile);
        $this->saveThumbnail();
    }
    
    /**
     * Saves thumbnail
     * @return void
     */
    public function saveThumbnail()
    {
        if($this->createThumbnail)
        {
            $this->saveSizedImage();
        }
    }
    
    /**
     * Saves image with a particular size
     * @return void
     */
    public function saveSizedImage()
    {
        $thumbPath      = $this->thumbnailUploadPath;
        $fullImagePath  = $this->uploadPath;
        if(!empty($this->savedFile))
        {
            $thumbImage     = $thumbPath . DS . $this->thumbWidth . '_' . $this->thumbHeight . '_' . $this->savedFile;
            if(file_exists($thumbImage) && is_file($thumbImage))
            {
                unlink($thumbImage);
            }
        }
        $imageName = $this->model->{$this->attribute};
        if(file_exists($fullImagePath . DS . $imageName))
        {
            Image::thumbnail($fullImagePath . DS . $imageName, $this->thumbWidth, $this->thumbHeight)
                            ->save($thumbPath . DS . $this->thumbWidth . '_' . $this->thumbHeight . '_' . $imageName, ['quality' => 80]);
        }
    }

    /**
     * @inheritdoc
     */
    public static function getType()
    {
        return 'image';
    }
    
    /**
     * Delete the file from uploads folder.
     * @return void
     */
    public function delete()
    {
        $path       = $this->uploadPath;
        $thumbPath  = $this->thumbnailUploadPath;
        $fileName   = $this->model->{$this->attribute};
        $filePath   = FileUtil::normalizePath($path . DS . $fileName);
        if(file_exists($filePath) && is_file($filePath))
        {
            unlink($filePath);
        }
        if($this->createThumbnail)
        {
            $thumbFilePath   = FileUtil::normalizePath($thumbPath . DS . $this->thumbWidth . '_' . $this->thumbHeight . '_' . $fileName);
            if(file_exists($thumbFilePath) && is_file($thumbFilePath))
            {
                unlink($thumbFilePath);
            }
        }
    }
    
    /**
     * Saves custom sized image by reading the source file.
     * @param string $targetImageName
     * @param string $sourceFilePath The complete path of the image including image name
     * @param string $targetPath The path where image has to be saved
     * @return ImageInterface
     */
    public function saveCustomThumbnailImageFromSource($targetImageName, $sourceFilePath, $targetPath = null)
    {
        if($targetPath == null)
        {
            $targetPath      = $this->thumbnailUploadPath;
        }
        return Image::thumbnail($sourceFilePath, $this->thumbWidth, $this->thumbHeight)
                        ->save($targetPath . DS . $this->thumbWidth . '_' . $this->thumbHeight . '_' . $targetImageName, ['quality' => 80]);
    }
    
    /**
     * Get thumbnail image
     * @return string
     */
    public function getThumbnailImage()
    {
        $model      = $this->model;
        $attribute  = $this->attribute;
        if(is_array($model))
        {
            $model = (object)$model;
        }
        if($model->$attribute == null)
        {
            return $this->getNoAvailableImage(['thumbWidth' => $this->thumbWidth, 'thumbHeight' => $this->thumbHeight]);
        }
        $prefix         = $this->getFilePrefix();
        $filePath       = $this->thumbnailUploadPath . DS . $prefix . $model->$attribute;
        $fullImagePath  = $this->uploadPath . DS . $model->$attribute;
        if(file_exists($fullImagePath))
        {
            //If thumbnail does not exist.
            if(!file_exists($filePath))
            {
                $this->saveSizedImage();
            }
        }
        else
        {   
            //In case image is there in databse but not in local folder.
            return $this->getNoAvailableImage(['thumbWidth' => $this->thumbWidth, 'thumbHeight' => $this->thumbHeight]);
        }
        $url        = $this->thumbnailUploadUrl . '/' . $prefix . $model->$attribute;
        return Html::img($url, ['width' => $this->thumbWidth, 'height' => $this->thumbHeight, 'class' => $this->cssClass]);
    }
    
    /**
     * Get file prefix
     * @param array $htmlOptions
     * @return string
     */
    public function getFilePrefix()
    {
        $width     = $this->thumbWidth != null ? $this->thumbWidth : $this->defaultThumbWidth;
        $height    = $this->thumbHeight != null ? $this->thumbHeight : $this->defaultThumbHeight;
        $htmlOptions['width'] = $width;
        $htmlOptions['height'] = $height;
        return $width . '_' . $height . '_';
    }
    
    /**
     * Get no available image
     * @return string
     */
    public function getNoAvailableImage($htmlOptions = [])
    {
        $noAvailableImage   = $this->noAvailableImageName;
        $noAvailableImageSourcePath = UsniAdaptor::getAlias($this->noAvailableImagePath);
        $sourcePath         = FileUtil::normalizePath($noAvailableImageSourcePath . DS . $noAvailableImage);
        $defaultWidth       = $this->thumbWidth != null ? $this->thumbWidth : $this->defaultThumbWidth;
        $defaultHeight      = $this->thumbHeight != null ? $this->thumbHeight : $this->defaultThumbHeight;
        $width              = ArrayUtil::popValue('thumbWidth', $htmlOptions, $defaultWidth);
        $height             = ArrayUtil::popValue('thumbHeight', $htmlOptions, $defaultHeight);
        $prefix             = $width . '_' . $height . '_';
        $thumbFilePath      = $this->thumbnailUploadPath . DS . $prefix . $noAvailableImage;
        if(!file_exists($thumbFilePath))
        {
            $this->saveCustomThumbnailImageFromSource($noAvailableImage, $sourcePath);
        }
        $url = StringUtil::replaceBackSlashByForwardSlash($this->thumbnailUploadUrl . DS . $prefix . $noAvailableImage);
        return Html::img($url, ['width' => $width, 'height' => $height]); 
    }
}