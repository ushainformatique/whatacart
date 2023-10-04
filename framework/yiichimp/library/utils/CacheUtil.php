<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\utils;

use usni\UsniAdaptor;
/**
 * CacheUtil class file.
 * 
 * @package usni\library\utils
 */
class CacheUtil
{
    /**
     * Clears the cache.
     * @return void.
     */
    public static function clearCache()
    {
        UsniAdaptor::app()->cache->flush();
    }

    /**
     * @inheritdoc
     */
    public static function set($key, $value, $duration = 0, $dependency = null)
    {
        UsniAdaptor::app()->cache->set($key, $value, $duration, $dependency);
    }

    /**
     * @inheritdoc
     */
    public static function get($key)
    {
        return UsniAdaptor::app()->cache->get($key);
    }
    
    /**
     * Delete a value from cache with a specified key.
     * @param mixed $key a key identifying the cached value. This can be a simple string or
     * a complex data structure consisting of factors representing the key.
     */
    public static function delete($key)
    {
        UsniAdaptor::app()->cache->delete($key);
    }
}