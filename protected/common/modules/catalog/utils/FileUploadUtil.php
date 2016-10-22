<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\catalog\utils;

use usni\library\utils\FileUploadUtil as BaseFileUploadUtil;
/**
 * Utility functions related to file upload for product.
 * 
 * @package common\modules\catalog\utils
 */
class FileUploadUtil extends BaseFileUploadUtil
{   
    /**
     * @inheritdoc
     */
    public static function getNoAvailableImageName()
    {
        return 'no_product.jpg';
    }
    
    /**
     * @inheritdoc
     */
    public static function getNoAvailableImageSourcePath()
    {
        return __DIR__ . DS . '..' . DS . 'assets' . DS . 'images';
    }
}