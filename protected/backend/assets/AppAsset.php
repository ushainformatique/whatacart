<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace backend\assets;

use yii\web\AssetBundle;
/**
 * Application asset for the backend
 * 
 * @package backend\assets
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
        'css/admin.css'
    ];
    
    public $js = [];
    
    public $depends = [
        'usni\library\web\AdminAssetBundle'
    ];
}
