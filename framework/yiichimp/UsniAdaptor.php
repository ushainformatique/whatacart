<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni;

use Yii;
use usni\library\utils\StringUtil;
use usni\library\utils\ArrayUtil;
use yii\db\Expression;
use usni\library\web\Application;
/**
 * UsniAdaptor class file.
 *
 * This class acts as an adaptor to Yii framework and returns different components for it like
 * UsniAdaptor::app(), Yii::$app->request so in future if the framework changes it would not have the impact on
 * the application. It also acts as the base helper class for any application build using the framework.
 *
 * @package usni
 */
class UsniAdaptor
{
    /**
	 * Returns the application instance.
	 * @return Application
	 */
    public static function app()
    {
        return Yii::$app;
    }

    /**
     * Gets alias path.
     * Wraps around getPathOfAlias of Yii 1.1
     * @param string $key
     * @param bool $throwException whether to throw an exception if the given alias is invalid.
     * @return void
     */
    public static function getAlias($key, $throwException = true)
    {
        if (strncmp($key, '@', 1))
        {
            return Yii::getAlias('@' . $key, $throwException);
        }
        return Yii::getAlias($key, $throwException);
    }

    /**
     * Wraps around Yii::t function.
	 * @param string $category the message category.
     * @param string $message the message to be translated.
     * @param array $params the parameters that will be used to replace the corresponding placeholders in the message.
     * @param string $language the language code (e.g. `en-US`, `en`). If this is null, the current
     * [[\yii\base\Application::language|application language]] will be used.
     * @return string the translated message.
     */
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t($category, $message, $params, $language);
    }

    /**
     * Wraps create url method.
     * @param string $route
     * @param array $params
     * @return string
     */
    public static function createUrl($route, $params = [])
    {
        $urlParams = [$route];
        $urlParams = ArrayUtil::merge($urlParams, $params);
        return self::app()->urlManager->createUrl($urlParams);
    }
    
    /**
     * Wraps create absoulte url method.
     * @param string $route
     * @param array $params
     * @param string $scheme the scheme to use for the url (either `http` or `https`). If not specified
     * the scheme of the current request will be used.
     * @return string
     */
    public static function createAbsoluteUrl($route, $params = [], $scheme = null)
    {
        $urlParams = [$route];
        $urlParams = ArrayUtil::merge($urlParams, $params);
        return self::app()->urlManager->createAbsoluteUrl($urlParams, $scheme);
    }

    /**
     * Get request param
     * @param string $param
     * @return mixed
     */
    public static function getRequestParam($param, $defaultValue = null)
    {
        return self::app()->request->get($param, $defaultValue);
    }

    /**
     * Return object base class name without namespace.
     * @param Object|String $object
     * @return string
     */
    public static function getObjectClassName($object)
    {
        if(is_string($object))
        {
            $qualifiedName = $object;
        }
        else
        {
            $qualifiedName = get_class($object);
        }
        return StringUtil::basename($qualifiedName);
    }

    /**
     * Get yii request object
     * @return \yii\web\Request|\yii\console\Request the request component.
     */
    public static function getRequest()
    {
        return self::app()->getRequest();
    }

    /**
     * Get db command.
     * @return \Yii::$app->db
     */
    public static function db()
    {
        return Yii::$app->db;
    }
    
    /**
     * Get table prefix
     * @return string
     */
    public static function tablePrefix()
    {
        return UsniAdaptor::app()->db->tablePrefix;
    }
    
    /**
     * Get now db expression
     * @return Expression
     */
    public static function getNow()
    {
        return new Expression('NOW()');
    }
}