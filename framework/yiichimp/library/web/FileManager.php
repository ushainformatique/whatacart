<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\web;

use usni\UsniAdaptor;
use usni\library\utils\FileUtil;

/**
 * FileManager class file
 * 
 * @package usni\library\web
 */
class FileManager extends BaseFileManager
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        if($this->uploadPath == null)
        {
            $this->uploadPath = UsniAdaptor::app()->assetManager->fileUploadPath;
        }
    }
    
    /**
     * @inheritdoc
     */
    public static function getType()
    {
        return 'file';
    }
    
    /**
     * Delete the file from uploads folder.
     * @return void
     */
    public function delete()
    {
        $path       = $this->uploadPath;
        $fileName   = $this->model->{$this->attribute};
        $filePath   = FileUtil::normalizePath($path . DS . $fileName);
        if(file_exists($filePath) && is_file($filePath))
        {
            unlink($filePath);
        }
    }
}
