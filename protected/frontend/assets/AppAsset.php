<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\assets;

use usni\library\web\UiAssetBundle;
use usni\UsniAdaptor;
use usni\library\utils\ConfigurationUtil;
/**
 * Application asset
 *
 * @package frontend\assets
 */
class AppAsset extends UiAssetBundle
{    
    /**
     * @inheritdoc
     */
    public function init()
    {
        $theme   = null;
        $store   = UsniAdaptor::app()->storeManager->getCurrentStore();
        if($store->theme != null)
        {   
            $theme  = $store->theme;
        }
        else
        {
            $theme  = ConfigurationUtil::getValue('application', 'frontTheme');
        }
        $this->basePath  = "@approot/themes/$theme/assets";
        $this->baseUrl   = "@appurl/themes/$theme/assets";
    }
    
    public $css = [
        'css/stylesheet.css',
        'css/bootstrap-theme.css',
        "//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=latin,cyrillic-ext"
    ];
    public $js = [
        'js/application.js'
    ];
    
    public $depends = [
        'usni\library\assets\UiFrontAssetBundle',
    ];
}
