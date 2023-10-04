<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\install\dto;

use usni\library\dto\FormDTO;
/**
 * InstallFormDTO class file.
 * 
 * @package usni\library\modules\install\dto
 */
class InstallFormDTO extends FormDTO
{
    /*
     * @var array 
     */
    private $_environments;
    
    /**
     * @var array 
     */
    private$_settings;
    
    /**
     * Configuration file path.
     * @var string
     */
    private $_targetConfigFilePath;
    /**
     * Instance Configuration file path.
     * @var string
     */
    private $_targetInstanceConfigFilePath;
    
    /**
     * Error message while running installation
     * @var string 
     */
    private $_errorMessage;
    
    /**
     * Config file for the application. Normally it would be instance.php
     * @var string 
     */
    private $_configFile;
    
    /**
     * Array of message while installation.
     * @var array 
     */
    private $_messages = [];
    
    public function getEnvironments()
    {
        return $this->_environments;
    }

    public function setEnvironments($environments)
    {
        $this->_environments = $environments;
    }

    public function getSettings()
    {
        return $this->_settings;
    }

    public function setSettings($settings)
    {
        $this->_settings = $settings;
    }
    
    public function getTargetConfigFilePath()
    {
        return $this->_targetConfigFilePath;
    }

    public function getTargetInstanceConfigFilePath()
    {
        return $this->_targetInstanceConfigFilePath;
    }

    public function setTargetConfigFilePath($targetConfigFilePath)
    {
        $this->_targetConfigFilePath = $targetConfigFilePath;
    }

    public function setTargetInstanceConfigFilePath($targetInstanceConfigFilePath)
    {
        $this->_targetInstanceConfigFilePath = $targetInstanceConfigFilePath;
    }
    
    public function getErrorMessage()
    {
        return $this->_errorMessage;
    }

    public function setErrorMessage($errorMessage)
    {
        $this->_errorMessage = $errorMessage;
    }
    
    public function getConfigFile()
    {
        return $this->_configFile;
    }

    public function setConfigFile($configFile)
    {
        $this->_configFile = $configFile;
    }
    
    public function getMessages()
    {
        return $this->_messages;
    }

    public function setMessages($messages)
    {
        $this->_messages = $messages;
    }
    
    public function addMessage($message)
    {
        $this->_messages[] = $message;
        $this->setMessages($this->_messages);
    }
}