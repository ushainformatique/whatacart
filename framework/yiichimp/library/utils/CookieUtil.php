<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\utils;

use usni\UsniAdaptor;
/**
 * Class consisting of utility functions related to cookie.
 * 
 * @package usni\library\utils
 */
class CookieUtil
{
    /**
     * inheritdoc
     * @see \yii\web\CookieCollection::getValue
     */
    public static function getValue($cookieName, $defaultValue = null)
    {
        return UsniAdaptor::app()->getRequest()->getCookies()->getValue($cookieName, $defaultValue);
    }
    
    /**
     * inheritdoc
     */
    public static function remove($cookieName, $removeFromBrowser = true)
    {
        UsniAdaptor::app()->getResponse()->getCookies()->remove($cookieName, $removeFromBrowser);
    }
    
    /**
     * Remove all cookies.
     * @return void
     */
    public static function removeAllCookies()
    {
        UsniAdaptor::app()->getResponse()->getCookies()->removeAll();
    }
}