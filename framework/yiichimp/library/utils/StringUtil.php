<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\utils;
/**
 * String utility functions.
 * 
 * @package usni\library\utils
 */
class StringUtil extends \yii\helpers\StringHelper
{
    /**
     * Gets random string.
     *
     * @param integer $length           String length.
     * @param integer $encryption_level Encryption level.
     *
     * @return string
     */
    public static function getRandomString($length = null, $encryption_level = 5)
    {
        if($length == null || intval($length) <= 0)
        {
            return null;
        }

        $str = null;
        for ($i = 0; $i < $encryption_level; $i++)
        {
            $str = base64_encode(md5(microtime(true)) . $str);
        }
        return substr($str, 0, $length);
    }

    /**
     * Get chopped string.
     * @param string $str
     * @param int $length
     * @param string $suffix
     * @return string
     */
    public static function getChoppedString($str, $length, $suffix = '..')
    {
        if(strlen($str) > $length)
        {
            return substr($str, 0, $length -2) . $suffix;
        }
        return $str;
    }
    
    /**
     * Convert string to array
     * @param string $str
     * @return array
     */
    public static function convertToArray($str)
    {
        if(is_string($str))
        {
            if(strpos($str, ',') > 0)
            {
                $data = explode(',', $str);
            }
            else
            {
                $data = [$str];
            }
        }
        else
        {
            $data = [];
        }
        return $data;
    }
    
    /**
     * Replace back slash by forward slash.
     * @param type $string
     * @return type
     */
    public static function replaceBackSlashByForwardSlash($string)
    {
        return str_replace('\\', '/', $string);
    }
}