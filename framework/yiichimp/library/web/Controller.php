<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\web;

use usni\UsniAdaptor;
use yii\helpers\Url;
/**
 * Base Controller class file. All controller classes for this application should extend from this base class.
 * 
 * @package usni\library\web
 */
class Controller extends \yii\web\Controller
{
    /**
     * Resolves default redirect url after login.
     * @return string
     */
    public function resolveDefaultAfterLoginUrl()
    {
        if(UsniAdaptor::app()->homeUrl == null)
        {
            $redirectUrl = Url::base(true);
        }
        else
        {
            $redirectUrl = Url::home(true);
        }
        return $redirectUrl;
    }
}