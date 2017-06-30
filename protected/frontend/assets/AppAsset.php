<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\assets;

use yii\web\AssetBundle;
/**
 * Application asset for the front end
 *
 * @package frontend\assets
 */
class AppAsset extends AssetBundle
{    
    public $basePath    = '@webroot';
    public $baseUrl     = '@web';
    
    public $css = [
        'css/stylesheet.css',
        'css/bootstrap-theme.css',
        "//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=latin,cyrillic-ext"
    ];
    public $js = [
        'js/application.js'
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'usni\fontawesome\FontAwesomeAsset'
    ];
}
