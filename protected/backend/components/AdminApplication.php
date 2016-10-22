<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace backend\components;

use usni\library\utils\CookieUtil;
use usni\UsniAdaptor;
use backend\components\Customer;
/**
 * AdminApplication extends UiAdminWebApplication by providing functions specific to admin app.
 * 
 * @package backend\components
 */
class AdminApplication extends \usni\library\components\UiAdminWebApplication
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if($this->installed === false)
        {
            CookieUtil::removeAllCookies();
        }
        else
        {
            UsniAdaptor::app()->setComponentInSession('customer', Customer::className(), 'customer');
        }
    }
    
    /**
     * @inheritdoc
     */
    public function powered()
    {
		return UsniAdaptor::t('application','Powered by {application}.', array('application'=>'<a href="http://whatacart.com" rel="external">WhatACart</a>'));
    }
}