<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\views\common;

use usni\library\views\UiView;
use usni\library\utils\ConfigurationUtil;
use usni\library\components\UiHtml;
use usni\UsniAdaptor;
use usni\library\utils\StringUtil;
use common\modules\stores\utils\StoreUtil;
/**
 * LogoView class file.
 *
 * @package frontend\views\commmon
 */
class LogoView extends UiView
{
    /**
     * Render content
     */
    protected function renderContent()
    {
        $logoContent    = null;
        $logo           = null;
        $storeLogo      = StoreUtil::getImageSetting('store_logo');
        if(!empty($storeLogo))
        {
            $logo = $storeLogo;
        }
        else
        {
            $logo = ConfigurationUtil::getValue('application', 'logo');
        }
        if($logo != null && $logo != 'img_not_available.png')
        {
            $storeImageWidth      = StoreUtil::getImageSetting('store_image_width', 268);
            $storeImageHeight     = StoreUtil::getImageSetting('store_image_height', 100);
            $logoContent = StringUtil::replaceBackSlashByForwardSlash(UiHtml::img(UsniAdaptor::app()->getAssetManager()->getImageUploadUrl() . DS . $logo, 
                                                                                  ['alt' => UsniAdaptor::app()->name, 'title' => UsniAdaptor::app()->name, 'width' => $storeImageWidth, 'height' => $storeImageHeight, 'class' => 'img-responsive']));
            $logoContent = UiHtml::a($logoContent, UsniAdaptor::createUrl('site/default/index'));
        }
        else
        {
            $logoContent = UiHtml::tag('h1', UiHtml::a(UsniAdaptor::app()->name, UsniAdaptor::createUrl('site/default/index')));
        }
        return $logoContent;
    }
}
