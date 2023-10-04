<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\install;

use usni\UsniAdaptor;
use yii\helpers\Url;
/**
 * Provides functionality related to installation.
 * 
 * @package usni\library\modules\install
 */
class Module extends \usni\library\components\Module
{
    /**
     * @var array Default sequence in which data for the modules would be installed  
     */
    public $defaultModuleDataInstallSequence = ['language', 'notification', 'users', 'auth'];
    
    /**
     * @var array Sequence in which data for the modules would be installed  
     */
    public $moduleDataInstallSequence = [];
    
    /**
     * @var array modules for which data would not be installed 
     */
    public $excludedModulesFromDataInstall = [];
    
    /**
     * Overrides to register translations.
     */
    public function init()
    {
        parent::init();
        $this->registerTranslations();
        if(empty($this->moduleDataInstallSequence))
        {
            $this->moduleDataInstallSequence = $this->defaultModuleDataInstallSequence;
        }
    }
    
    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) 
        {
            return false;
        }
        /*
         * If app is already installed redirect to home page
         */
        if(UsniAdaptor::app()->isInstalled())
        {
            $url = Url::home();
            UsniAdaptor::app()->getResponse()->redirect($url)->send();
            return;
        }
        return true;
    }

    /**
     * Registers translations.
     */
    public function registerTranslations()
    {   
        UsniAdaptor::app()->i18n->translations['installflash*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@approot/messages'
        ];
        UsniAdaptor::app()->i18n->translations['install*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@approot/messages'
        ];
        UsniAdaptor::app()->i18n->translations['installhint*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@approot/messages'
        ];
    }
}
