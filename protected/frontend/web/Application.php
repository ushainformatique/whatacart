<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace frontend\web;

use usni\UsniAdaptor;
/**
 * Application extends base functionality specific to whatacart for the frontend.
 * 
 * @package frontend\web
 */
class Application extends \usni\library\web\Application
{
    use \common\traits\WebApplicationTrait;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->setDatabaseConfig();
        $this->setDateTimeConfig();
        $this->loadAdditionalModuleConfig('@common/config/moduleconfig.php');
        $this->loadAdditionalModuleConfig('@frontend/config/moduleconfig.php');
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
    
    /**
     * @inheritdoc
     */
    public function setVendorPath($path)
    {
        parent::setVendorPath($path);
        if(!is_dir(VENDOR_PATH . DIRECTORY_SEPARATOR . 'bower'))
        {
            \Yii::setAlias('@bower', VENDOR_PATH . DIRECTORY_SEPARATOR . 'bower-asset');
        }
    }
}