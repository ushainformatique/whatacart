<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\traits;

use usni\UsniAdaptor;
use usni\library\utils\FileUtil;
use usni\library\modules\auth\business\AuthManager;
use usni\library\utils\ArrayUtil;
/**
 * ApplicationTrait implement common functions related to application
 *
 * @package usni\library\traits
 */
trait ApplicationTrait
{
    /**
     * Check if application is installed.
     * @var boolean
     */
    public $installed;

    /**
     * Environment in which application is running dev/test/prod
     * @var string
     */
    public $environment;

    /**
     * Powered by url for the application 
     * @var string 
     */
    public $poweredByUrl;
    
    /**
     * Powered by for the application 
     * @var string 
     */
    public $poweredByName;
    
    /**
     * Extended models configuration. This consist of rules, labels, hints etc.
     * @var array 
     */
    public $extendedModelsConfig;
    
    /**
     * @inheritdoc
     */
    public function setRuntimePath($path)
    {
        $runtimePath = realpath($path);
        if ($runtimePath === false)
        {
            FileUtil::createDirectory($path);
        }
        parent::setRuntimePath($path);
    }

    /**
     * Checks if application is installed or not.
     * @return boolean
     */
    public function isInstalled()
    {
        return $this->installed;
    }

    /**
     * Sets the cache component for the application.
     * @return void
     */
    public function setCacheComponent()
    {
        if(!is_object(UsniAdaptor::app()->cache))
        {
            UsniAdaptor::app()->set('cache', new \yii\caching\DummyCache());
        }
    }

    /**
     * @inheritdoc
     */
    public function getModule($id, $load = true)
    {
        $instantiatedModules = $this->moduleManager->getInstantiatedModules();
        if(isset($instantiatedModules[$id]))
        {
            return $instantiatedModules[$id];
        }
        else
        {
            return parent::getModule($id, $load);
        }
    }
    
    /**
     * @inheritdoc
     */
    protected function bootstrap()
    {
        \Yii::setAlias('approot', APPLICATION_PATH);
        if ($this->extensions === null) 
        {
            $file = UsniAdaptor::getAlias('@vendor/yiisoft/extensions.php');
            $this->extensions = is_file($file) ? include($file) : [];
            $file = UsniAdaptor::getAlias('@approot/extensions.php');
            if(file_exists($file))
            {
                $extensions = include($file);
                $this->extensions = ArrayUtil::merge($this->extensions, $extensions);
            }
        }
        parent::bootstrap();
    }
    
    /**
     * Load additional module config.
     * @param string $aliasedPath
     */
    public function loadAdditionalModuleConfig($aliasedPath)
    {
        $moduleConfigFile = UsniAdaptor::getAlias($aliasedPath);
        if(file_exists($moduleConfigFile))
        {
            $moduleConfig = require(FileUtil::normalizePath($moduleConfigFile));
            foreach($moduleConfig as $moduleKey => $value)
            {
                $module = UsniAdaptor::app()->getModule($moduleKey);
                \Yii::configure($module, $value);
            }
        }
    }
    
    /**
     * Returns the authorization manager component.
     * @return AuthManager the authorization manager component.
     */
    public function getAuthorizationManager()
    {
        return $this->get('authorizationManager');
    }
    
    /**
     * Returns the config manager component.
     * @return ConfigManager the config manager component.
     */
    public function getConfigManager()
    {
        return $this->get('configManager');
    }
}
