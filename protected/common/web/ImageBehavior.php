<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\web;

use usni\library\utils\FileUploadUtil;
use usni\UsniAdaptor;
use usni\library\utils\Html;
/**
 * Implement common functions related to images
 *
 * @package common\web
 */
class ImageBehavior extends \yii\base\Behavior
{
    /**
     * Render image based on type for the store image setting.
     * @param Model $model
     * @param string $attribute Image attribute.
     * @param string $type Type of image for store image setting
     * @param int $width
     * @param int $height
     * @return string
     */
    public function renderImageByStoreSettings($model, $attribute, $type, $width, $height)
    {
        $imageThumbWidth     = UsniAdaptor::app()->storeManager->getImageSetting($type . '_image_width', $width);
        $imageThumbHeight    = UsniAdaptor::app()->storeManager->getImageSetting($type . '_image_height', $height);
        return FileUploadUtil::getThumbnailImage($model, $attribute, ["thumbWidth"=> $imageThumbWidth , "thumbHeight" => $imageThumbHeight]);
    }
    
    /**
     * Get no profile image
     * @param array $htmlOptions
     * @return string
     */
    public function getNoProfileImage($htmlOptions = [])
    {
        $noImagePath    = UsniAdaptor::app()->getModule('users')->getBasePath() . DS . 'assets' . DS . 'images' . DS . 'no_profile.jpg';
        $publishedData  = UsniAdaptor::app()->assetManager->publish($noImagePath);
        if(empty($htmlOptions))
        {
            $htmlOptions = ['width' => 64, 'height' => 64];
        }
        return Html::img($publishedData[1], $htmlOptions);
    }
    
    /**
     * Get fav icon.
     * @return string
     */
    public function getFavIcon()
    {
        $icon = UsniAdaptor::app()->storeManager->getImageSetting('icon');
        if(!empty($icon))
        {
            return UsniAdaptor::app()->getAssetManager()->getImageUploadUrl() . DS . $icon;
        }
        return "/images/favicon.ico";
    }
}
