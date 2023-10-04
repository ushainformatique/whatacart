<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\fontawesome;

use yii\web\AssetBundle;

/**
 * Fontawesome asset bundle.
 * 
 * @see http://www.yiiframework.com/doc-2.0/guide-structure-assets.html
 * @package usni\library\assets
 */
class FontAwesomeAsset extends AssetBundle
{
    public $sourcePath = '@vendor/fortawesome/font-awesome';
    public $css = [
        'css/font-awesome.min.css',
    ];
}