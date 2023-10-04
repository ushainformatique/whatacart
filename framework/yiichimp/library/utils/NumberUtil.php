<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\utils;

/**
 * NumberUtil class file.
 * 
 * @package usni\library\utils
 */
class NumberUtil
{
    /**
     * Compare float
     * @param float $a
     * @param float $b
     * @return boolean
     */
    public static function compareFloat($a, $b)
    {
        $epsilon = 0.00001;
        if(abs($a - $b) < $epsilon) 
        {
            return true;
        }
        return false;
    }
}