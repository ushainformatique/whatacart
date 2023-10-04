<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\components;

use usni\library\utils\ObjectUtil;
use Yii;
/**
 * This is the base module class for the framework.
 * 
 * @package usni\library\components
 */
abstract class Module extends \yii\base\Module
{
    /**
     * Data manager path.
     * @var array
     */
    private $_dataManagerPath = array();
    /**
     * Table manager.
     * @var string
     */
    private $_tableManager;
    
    /**
     * Data manager.
     * @var string
     */
    private $_dataManager;
    
    /**
     * Initializes the module.
     * @return void
     */
    public function init()
    {
        parent::init();
        //Include the config
        $configFile = $this->getBasePath() . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'main.php';
        if(file_exists($configFile))
        {
            $config = require($configFile);
            if(!empty($config))
            {
                Yii::configure($this, $config);
            }
        }
    }

    /**
     * Sets data manager path.
     * @param array $paths
     * @return void
     */
    public function setDataManagerPath($paths = array())
    {
        $this->_dataManagerPath = $paths;
    }

    /**
     * Get data manager path.
     * @return array
     */
    public function getDataManagerPath()
    {
        if(!empty($this->_dataManagerPath))
        {
            return $this->_dataManagerPath;
        }
        $namespace       = $this->getNamespace();
        $basePath        = $namespace . '\db';
        return array($basePath);
    }

    /**
     * Gets module namespace.
     * @return string
     */
    public function getNamespace()
    {
        return ObjectUtil::getClassNamespace(get_class($this));
    }
    
    /**
     * Sets table manager.
     * @param $className string
     * @return void
     */
    public function setTableManager($className)
    {
        $this->_tableManager = $className;
    }

    /**
     * Get table manager.
     * @return array
     */
    public function getTableManager()
    {
        if(!empty($this->_tableManager))
        {
            return $this->_tableManager;
        }
        $namespace       = $this->getNamespace();
        return $namespace . '\db\TableManager';
    }
    
    /**
     * Get data manager.
     * @return string
     */
    public function getDataManager()
    {
        return $this->_dataManager;
    }
    
    /**
     * Sets data manager.
     * @param $className string
     * @return void
     */
    public function setDataManager($className)
    {
        $this->_dataManager = $className;
    }
}