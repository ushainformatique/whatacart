<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace backend\web;

use usni\UsniAdaptor;
/**
 * Application extends base functionality specific to whatacart for the backend.
 * 
 * @package backend\web
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
        $this->setHomeUrl(UsniAdaptor::createUrl('home/default/dashboard'));
        $this->loadAdditionalModuleConfig('@common/config/moduleconfig.php');
        $this->loadAdditionalModuleConfig('@backend/config/moduleconfig.php');
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