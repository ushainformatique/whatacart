<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\fontawesome;

use usni\fontawesome\components\Icon;
/**
 * FA class file.
 * 
 * @package usni\fontawesome
 * @see https://github.com/rmrevin/yii2-fontawesome/blob/master/FontAwesome.php
 */
class FA
{
    /**
    * Size values
    * @see Icon::size
    */
    const SIZE_LARGE = 'lg';
    const SIZE_2X = '2x';
    const SIZE_3X = '3x';
    const SIZE_4X = '4x';
    const SIZE_5X = '5x';
    /**
    * Rotate values
    * @see Icon::rotate
    */
    const ROTATE_90 = 90;
    const ROTATE_180 = 180;
    const ROTATE_270 = 270;
    /**
    * Flip values
    * @see Icon::flip
    */
    const FLIP_HORIZONTAL = 'horizontal';
    const FLIP_VERTICAL = 'vertical';
    /**
     * Get font awesome icon
     * @param string $name
     * @param array $options
     */
    public static function icon($name, $options = [])
    {
        return new Icon($name, $options);
    }
}
