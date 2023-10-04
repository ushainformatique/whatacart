<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\widgets;

use usni\library\utils\Html;
/**
 * Implements the lightbox2 functionality in Yii2
 *
 * @package usni\library\widgets
 */
class Lightbox extends \branchonline\lightbox\Lightbox
{
    /**
     * Container into which all images are stored
     * @var string 
     */
    public $containerTag = 'div';
    
    /**
     * Html options for the container
     * @var array 
     */
    public $containerOptions = [];
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        $html = '';
        foreach ($this->files as $file)
        {
            if (!isset($file['thumb']) || !isset($file['original']))
            {
                continue;
            }

            $attributes = [
                'data-title' => isset($file['title']) ? $file['title'] : '',
                //Add this so that class can be added to each link
                'class'      => isset($file['class']) ? $file['class'] : '',
            ];

            if (isset($file['group']))
            {
                $attributes['data-lightbox'] = $file['group'];
            }
            else
            {
                $attributes['data-lightbox'] = 'image-' . uniqid();
            }
            $thumbAttributes = [
                //Add this so that class can be added to each image
                'class'      => isset($file['thumbclass']) ? $file['thumbclass'] : '',
                'id'         => isset($file['id']) ? $file['id'] : '',
            ];
            $img    = Html::img($file['thumb'], $thumbAttributes);
            $a      = Html::a($img, $file['original'], $attributes);
            if($file['itemTag'] != null)
            {
                $itemOptions = ArrayUtil::getValue($file, 'itemOptions', []);
                $a = Html::tag($file['itemTag'], $a, $itemOptions);
            }
            $html .= $a;
        }
        if($this->containerTag != null)
        {
            $html = Html::tag($this->containerTag, $html, $this->containerOptions);
        }
        return $html;
    }
}