<?php

/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\web;

/**
 * InstallResponse class file
 *
 * @package usni\library\modules\install\web
 */
class Response extends \yii\web\Response
{
    private $_headers;
    private $_cookies;
    private $_statusCode = 200;
    
    /**
     * Sends the response headers to the client. This is done to avoid 
     * HeaderAlready sent exception in the application
     */
    protected function sendHeaders()
    {
        if (headers_sent())
        {
            return;
        }
        $headers = $this->getHeaders();
        foreach ($headers as $name => $values)
        {
            $name = str_replace(' ', '-', ucwords(str_replace('-', ' ', $name)));
            // set replace for first occurrence of header but false afterwards to allow multiple
            $replace = true;
            foreach ($values as $value)
            {
                header("$name: $value", $replace);
                $replace = false;
            }
        }
        $statusCode = $this->getStatusCode();
        header("HTTP/{$this->version} {$statusCode} {$this->statusText}");
        $this->sendCookies();
    }
}
