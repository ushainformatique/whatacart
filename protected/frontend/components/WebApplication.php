<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\components;

use usni\library\components\UiFrontWebApplication;
use frontend\utils\FrontUtil;
use frontend\components\Guest;
use frontend\components\Customer;
use usni\UsniAdaptor;
use common\utils\ApplicationUtil;
/**
 * WebApplication class file.
 * 
 * @package frontend\components
 */
class WebApplication extends UiFrontWebApplication
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if($this->installed)
        {
            UsniAdaptor::app()->language = UsniAdaptor::app()->languageManager->getDisplayLanguage(); 
            FrontUtil::setTheme();
            $storeId = UsniAdaptor::app()->storeManager->getCurrentStore()->id;
            $userId  = ApplicationUtil::getCustomerId();
            if($userId == 0)
            {
                //Not setting customer as would not be required
                UsniAdaptor::app()->setComponentInSession('guest_' . $storeId, Guest::className(), 'guest');
            }
            else
            {
                //Not setting guest as would not be required
                UsniAdaptor::app()->setComponentInSession('customer_' . $storeId . '_' . $userId, Customer::className(), 'customer');
            }
            ApplicationUtil::registerGlobalScripts($this->getView());
        }
    }
    
    /**
     * Get front url.
     * @return string
     */
    public function getFrontUrl()
    {
        return \yii\helpers\Url::base('http');
    }
    
    /**
     * @inheritdoc
     */
    public function powered()
    {
		return UsniAdaptor::t('application','Powered by {application}.', array('application'=>'<a href="http://whatacart.com" rel="external">WhatACart</a>'));
    }
}