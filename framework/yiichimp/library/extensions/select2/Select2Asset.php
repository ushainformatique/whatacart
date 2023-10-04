<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\extensions\select2;

use yii\web\AssetBundle;
/**
 * Asset bundle related to Eselect2 extension.
 *
 * @package usni\library\extensions\select2
 */
class Select2Asset extends AssetBundle
{
    public $sourcePath = '@usni/library/extensions/select2/assets';

    public $css = [
        'css/select2.css',
        'css/select2-bootstrap.css',
    ];

    public $js = ['js/select2.min.js'];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
