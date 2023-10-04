<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\utils;
/**
 * Contains utility methods related to array
 * 
 * @package usni\library\utils
 */
class ArrayUtil extends \yii\helpers\ArrayHelper
{
    /**
     * Removes and returns a specific value from the given array (or the default value if not set).
     *
     * @param string $key the item key.
     * @param array $array the array to pop the item from.
     * @param mixed $defaultValue the default value.
     *
     * @see http://www.cniska.net/yii-bootstrap/#TbArray::popValue
     *
     * @return mixed the value.
     */
    public static function popValue($key, array &$array, $defaultValue = null)
    {
        return self::remove($array, $key, $defaultValue);
    }

    /**
     * Sets the default value for a specific key in the given array.
     *
     * @param string $key the item key.
     * @param mixed $value the default value.
     * @param array $array the array.
     *
     * @return void
     */
    public static function defaultValue($key, $value, array &$array)
    {
        if (!isset($array[$key]))
        {
            $array[$key] = $value;
        }
    }

    /**
     * Sets a set of default values for the given array.
     * @param array $array the array to set values for.
     * @param array $values the default values.
     */
    public static function defaultValues(array $values, array &$array)
    {
        foreach ($values as $name => $value)
        {
            self::defaultValue($name, $value, $array);
        }
    }

    /**
     * Removes a set of items from the given array.
     *
     * @param array $keys the keys to remove.
     * @param array $array the array to remove from.
     *
     * @return void
     */
    public static function removeValues(array $keys, array &$array)
    {
        $array = array_diff_key($array, array_flip($keys));
    }

    /**
     * Copies the given values from one array to another.
     *
     * @param array $keys the keys to copy.
     * @param array $from the array to copy from.
     * @param array $to the array to copy to.
     * @param boolean $force whether to allow overriding of existing values.
     *
     * @return array the options.
     */
    public static function copyValues(array $keys, array $from, array $to, $force = false)
    {
        foreach ($keys as $key)
        {
            if (isset($from[$key]))
            {
                if ($force || !isset($to[$key]))
                {
                    $to[$key] = self::getValue($from, $key);
                }
            }
        }
        return $to;
    }

    /**
     * Moves the given values from one array to another.
     *
     * @param array $keys the keys to move.
     * @param array $from the array to move from.
     * @param array $to the array to move to.
     * @param boolean $force whether to allow overriding of existing values.
     *
     * @return array the options.
     */
    public static function moveValues(array $keys, array &$from, array $to, $force = false)
    {
        foreach ($keys as $key)
        {
            if (isset($from[$key]))
            {
                $value = self::popValue($key, $from);
                if ($force || !isset($to[$key]))
                {
                    $to[$key] = $value;
                    unset($from[$key]);
                }
            }
        }
        return $to;
    }

    /**
     * Array unshift with associated array
     * @param array $arr
     * @param string $key
     * @param string $val
     */
    public static function unshiftAssoc($arr, $key, $val)
    {
        $arr = array_reverse($arr, true);
        $arr[$key] = $val;
        return array_reverse($arr, true);
    }
}