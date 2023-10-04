<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\components;

use usni\UsniAdaptor;
use usni\library\utils\FileUtil;
use yii\helpers\Json;
use usni\library\utils\ArrayUtil;
use usni\library\utils\CacheUtil;
/**
 * ModuleManager class file.
 * 
 * @package usni\library\components
 */
class ModuleManager extends \yii\base\Component
{
    /**
     * Contains modules that are instantiated.
     * @var array
     */
    protected $instantiatedModules;
    
    /**
     * Modules excluded from autoload.
     * @var array
     */
    protected $excludedModulesFromAutoload = ['gii'];
    
    /**
     * List of module paths. The path should be an alias like @common/modules
     * @var array 
     */
    public $modulePaths = [];
    
    /**
     * Initialize modules
     * @return void
     */
    public function bootstrap()
    {
        //Get modules configured using native yii way
        $appConfiguredModules = $this->loadInstalledModules(UsniAdaptor::app()->getModules());
        $moduleMetadata = $this->buildModuleConfig();
        $data = Json::decode($moduleMetadata);
        UsniAdaptor::app()->setModules($data);
        $this->instantiatedModules = ArrayUtil::merge($appConfiguredModules, $this->loadInstalledModules(UsniAdaptor::app()->getModules()));
    }
    
    /**
     * Build module configuration.
     * @return void
     */
    public function buildModuleConfig()
    {
        $moduleMetadata     = CacheUtil::get('moduleMetadata');
        if(empty($moduleMetadata))
        {
            $modulePaths        = $this->prepareModulePaths();
            $moduleConfig       = [];
            foreach($modulePaths as $modulePath)
            {
                $path       = FileUtil::normalizePath($modulePath);
                if(is_dir($path))
                {
                    $modules    = scandir($path);
                    foreach ($modules as $moduleId) 
                    {
                        if($moduleId == '.' || $moduleId == '..')
                        {
                            continue;
                        }
                        if (is_dir($path . DS . $moduleId)) 
                        {
                            $initFile    = $path . DS . $moduleId . DS . 'config' . DS . 'init.php';
                            if(file_exists($initFile))
                            {
                                $data = require($initFile);
                                foreach($data as $key => $config)
                                {
                                    $moduleConfig[$key] = $config;
                                }
                            }
                        }
                    }
                }
            }
            $moduleMetadata = Json::encode($moduleConfig);
            CacheUtil::set('moduleMetadata', $moduleMetadata);
        }
        return $moduleMetadata;
    }

    /**
     * Loads the installed modules.
     * @return void
     */
    public function loadInstalledModules($modules, $parent = null)
    {
        $instantiatedModules = [];
        foreach ($modules as $key => $module)
        {
            if(is_array($module))
            {
                if (!in_array($key, $this->excludedModulesFromAutoload))
                {
                    $modifiedKey = $key;
                    if($parent != null)
                    {
                        $modifiedKey = $parent . '/' . $key;
                    }
                    $insModule = UsniAdaptor::app()->getModule($modifiedKey, true);
                    $instantiatedModules[$modifiedKey] = $insModule;
                    $instantiatedModules = ArrayUtil::merge($instantiatedModules, $this->loadInstalledModules($insModule->getModules(), $insModule->getUniqueId()));
                }
            }
            elseif(!in_array($module->uniqueId, $this->excludedModulesFromAutoload))
            {
                $instantiatedModules[$module->uniqueId] = $module;
            }
        }
        return $instantiatedModules;
    }

    /**
     * Returns a value indicating whether the specified module is instantiated.
     * @param string $id The module unique ID.
     * @return boolean whether the specified module is installed.
     */
    public function hasModuleInstantiated($id)
    {
        return isset($this->instantiatedModules[$id]);
    }

    /**
     * Returns the configuration of the currently instantiated modules.
     * @return array the configuration of the currently instantiated modules (module ID => configuration)
     */
    public function getInstantiatedModules()
    {
        return $this->instantiatedModules;
    }
    
    /**
     * Gets instantiated module keys.
     * @return array
     */
    public function getInstantiatedModulesKeys()
    {
        return array_keys($this->instantiatedModules);
    }
    
    /**
     * Prepare module paths.
     * @return array
     */
    public function prepareModulePaths()
    {
        $modulePaths = [];
        foreach($this->modulePaths as $path)
        {
            $modulePaths[] = UsniAdaptor::getAlias($path, false);
        }
        return $modulePaths;
    }
}