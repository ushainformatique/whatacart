<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\utils;

use usni\UsniAdaptor;
/**
 * Class consisting of utility functions related to request.
 *
 * @package usni\library\utils
 */
class RequestUtil
{
    /**
     * Gets default host information.
     * @return string
     */
    public static function getDefaultHostInfo()
    {
        $hostInfo = "";
        if (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] !='')
        {
            $hostInfo = 'http://' . $_SERVER['HTTP_HOST'];
        }
        elseif (isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME'] != '')
        {
            $hostInfo = 'http://' . $_SERVER['SERVER_NAME'];
        }
        return $hostInfo;
    }

    /**
     * Gets default script url
     * @param string $route
     * @return string
     */
    public static function getDefaultScriptUrl($route = '')
    {        
        if (isset($_SERVER['PHP_SELF']))
        {
            $url = rtrim($_SERVER['PHP_SELF'], '/');
            
            $route = rtrim($route, '/');
            if ($route != '')
            {
                $pos = strpos($url, $route);
                if($pos > 0)
                {
                    $url = substr($url, 0, $pos);
                }
                $url = rtrim($url, '/');
            }
            $indexPos = strpos($url, '/index.php');
            if($indexPos > 0)
            {
                $url = substr($url, 0, $indexPos);
            }
            return $url;
        }
        else
        {
            return '';
        }
    }
    
    /**
     * Get domain url
     * @return string
     */
    public static function getDomainUrl()
    {
        $url = \yii\helpers\Url::to('@web', true);
        //if access from backend in case of preview
        if(strpos($url, 'backend') > 0)
        {
            $url = str_replace('/backend', '', $url);   
        }
        return $url;
    }
}
