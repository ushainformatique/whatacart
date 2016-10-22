<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace backend\assets;

use usni\library\web\UiAssetBundle;
/**
 * Application asset
 * @package backend\assets
 */
class AppAsset extends UiAssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/admin.css'
    ];
    public $js = [];
    public $depends = [
        'usni\library\assets\UiAdminAssetBundle',
    ];
}
