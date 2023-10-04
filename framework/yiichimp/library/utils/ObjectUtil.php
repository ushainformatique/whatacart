<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\utils;

use usni\UsniAdaptor;
use usni\library\utils\FileUtil;
/**
 * ObjectUtil class file.
 * 
 * @package usni\library\utils
 */
class ObjectUtil
{
    /**
     * Get class public properties.
     * @param string $className
     * @param boolean $ignoreParentProperties Ignore parent class properties.
     * @return array
     */
    public static function getClassPublicProperties($className, $ignoreParentProperties = true)
    {
        $reflectionClass         = new \ReflectionClass($className);
        $publicPropertiesObjects = $reflectionClass->getProperties(\ReflectionProperty::IS_PUBLIC);
        $publicProperties        = array();
        foreach($publicPropertiesObjects as $object)
        {
            if($ignoreParentProperties)
            {
                if($object->class == $className)
                {
                    $publicProperties[] = $object->name;
                }
            }
            else
            {
                $publicProperties[] = $object->name;
            }
        }
        return $publicProperties;
    }
    
    /**
     * Get class namespace.
     * @param string $fullyQualifiedClassName
     * @return string
     */
    public static function getClassNamespace($fullyQualifiedClassName)
    {
        $reflectionClass = new \ReflectionClass($fullyQualifiedClassName);
        return $reflectionClass->getNamespaceName();
    }
    
    /**
     * Get full path by alias.
     * @param string $aliasedPath
     * @return string
     */
    public static function getPathByAlias($aliasedPath)
    {
        $path = UsniAdaptor::getAlias('@' . str_replace('\\', '/', $aliasedPath));
        return str_replace('\\', '/', $path);
    }
}