<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\install\business;

use yii\base\Component;
use usni\UsniAdaptor;
use usni\library\utils\DatabaseUtil;
use yii\db\Connection;
use usni\library\modules\users\business\Manager as UserManager;
use usni\library\utils\FileUtil;
use usni\library\modules\install\components\ApplicationRequirementChecker;
use usni\library\modules\install\dto\InstallFormDTO;
use usni\library\modules\install\models\SettingsForm;
use yii\web\UploadedFile;
use usni\library\utils\FileUploadUtil;
use usni\library\db\ApplicationTableManager;
use usni\library\modules\users\models\User;
/**
 * InstallManager class file.
 *
 * @package usni\library\modules\install\components
 */
class InstallManager extends Component
{
    /**
     * Key to install the app
     */
    const INSTALL_KEY = '4QKLfI-BWpDWOf258Otj3AalM9fE2lZD';
    
    /**
     * Configuration file path.
     * @var string
     */
    public $targetConfigFilePath;
    /**
     * Test Configuration file path.
     * @var string
     */
    public $targetTestConfigFilePath;
    /**
     * Instance Configuration file path.
     * @var string
     */
    public $targetInstanceConfigFilePath;
    
    /**
     * Set config files.
     * @param InstallFormDTO $formDTO
     * @return void
     */
    public function setConfigFiles($formDTO)
    {
        UsniAdaptor::app()->cache->flush();
        $configFile = $formDTO->getConfigFile();
        if($configFile != null)
        {
            $configFilePath             = UsniAdaptor::getAlias('@common/config');
            $formDTO->setTargetConfigFilePath($configFilePath . '/' . $configFile);
            $formDTO->setTargetInstanceConfigFilePath($configFilePath . '/instanceConfig.php');
        }
        else
        {
            $formDTO->setErrorMessage(UsniAdaptor::t('install', 'Configuration file is missing'));
            throw new \yii\base\InvalidConfigException();
        }
    }

    /**
     * Sets db component.
     * @param InstallFormDTO $formDTO
     */
    public function setDbComponent($formDTO)
    {
        $model = $formDTO->getModel();
        $dsn = 'mysql:host=' . $model->dbHost . ';dbname=' . $model->dbName . ';port=' . $model->dbPort . ';';
        $connection = new Connection();
        $connection->dsn = $dsn;
        $connection->username = $model->dbUsername;
        $connection->password = $model->dbPassword;
        $connection->charset = 'utf8';
        $connection->tablePrefix = 'tbl_';
        $connection->emulatePrepare = true;
        UsniAdaptor::app()->set('db', $connection);
    }

    /**
     * Writes config file.
     * @param InstallFormDTO $formDTO
     * @return void
     */
    public function writeConfigFile($formDTO)
    {
        $formDTO->addMessage(UsniAdaptor::t('install', 'Start writing configuration file'));
        //Read the config file from framework
        $configFilePath             = UsniAdaptor::getAlias('@usni/library/config');
        $configFile                 = $configFilePath . '/instance.install.php';
        copy($configFile, $formDTO->getTargetConfigFilePath());
        chmod($formDTO->getTargetConfigFilePath(), 0777);
        $this->replaceConfigVariables($formDTO->getModel(), $formDTO->getTargetConfigFilePath());
        //Instance config file
        $instanceConfigFile         = $configFilePath . '/instance.config.php';
        copy($instanceConfigFile, $formDTO->getTargetInstanceConfigFilePath());
        chmod($formDTO->getTargetInstanceConfigFilePath(), 0777);
        $formDTO->addMessage(UsniAdaptor::t('install', 'Configuration files created successfully'));
    }

    /**
     * Replace the config variables.
     * @param SettingsForm $model
     * @param string $configFile
     * @param $environment string
     * @return void
     */
    public function replaceConfigVariables($model, $configFile, $environment = null)
    {
        $content    = file_get_contents($configFile);
        $content    = str_replace('{{Application}}', $model->siteName, $content);
        $content    = str_replace('{{hostName}}', $model->dbHost, $content);
        $content    = str_replace('{{dbPort}}', $model->dbPort, $content);
        $content    = str_replace('{{dbName}}', $model->dbName, $content);
        $content    = str_replace('{{dbUserName}}', $model->dbUsername, $content);
        $content    = str_replace('{{dbPassword}}', $model->dbPassword, $content);
        //$content    = str_replace('{{testDbName}}', strtolower($model->dbName). '-test', $content);
        $content    = preg_replace('/\$installed\s*=\s*false;/', '$installed = true;', $content);
        if($environment == null)
        {
            $content    = str_replace('{{environment}}', $model->environment, $content);
        }
        else
        {
            $content    = str_replace('{{environment}}', $environment, $content);
        }
        //$content    = str_replace('{{frontTheme}}', $model->frontTheme, $content);
        file_put_contents($configFile, $content);
    }

    /**
     * Save configuration in database.
     * @param InstallFormDTO $formDTO
     * @return void
     */
    public function saveSettingsInDatabase($formDTO)
    {
        $configModel = $formDTO->getModel();
        foreach ($configModel->getAttributes() as $attribute => $value)
        {
            UsniAdaptor::app()->configManager->insertOrUpdateConfiguration('application', $attribute, $value);
        }
        //Set db schema caching
        UsniAdaptor::app()->configManager->insertOrUpdateConfiguration('application', 'enableSchemaCache', true);
        UsniAdaptor::app()->configManager->insertOrUpdateConfiguration('application', 'schemaCachingDuration', 3600);
    }
    
    /**
     * Create super user.
     * @param InstallFormDTO $formDTO
     */
    public function createSuperUser($formDTO)
    {
        $model = $formDTO->getModel();
        //Create super user
        UserManager::getInstance(['userId' => User::SUPER_USER_ID])->createSuperUser($model->getAttributes());
    }
    
    /**
     * Load permissions for the application.
     */
    public function loadPermissions()
    {
        UsniAdaptor::app()->authorizationManager->addModulesPermissions();
    }

    /**
     * Loads instance data
     * @param InstallFormDTO $formDTO
     * @return void
     */
    protected function loadInstanceData($formDTO)
    {
        $basePath = APPLICATION_PATH . '/data';
        //Check if instance sql exists or not.
        $databaseInstanceDataFile = $basePath . '/instancedbdata.sql';
        if(file_exists($databaseInstanceDataFile))
        {
            $sql  = file_get_contents($databaseInstanceDataFile);
            if(!empty($sql))
            {
                UsniAdaptor::db()->createCommand($sql)->execute();
            }
        }
        UsniAdaptor::db()->getSchema()->refresh();
        $formDTO->addMessage(UsniAdaptor::t('install', 'Adding instance data successfull'));
    }
    
    /**
     * Install default and demo data.
     * @param InstallFormDTO $formDTO
     */
    public function installDefaultAndDemoData($formDTO)
    {
        $transaction    = UsniAdaptor::db()->beginTransaction();
        try
        {
            $model          = $formDTO->getModel();
            //Load modules data
            $loadDemoData   = (bool)$model->demoData;
            $modules        = UsniAdaptor::app()->getModule('install')->moduleDataInstallSequence;
            if(empty($modules))
            {
                $modules        = UsniAdaptor::app()->getModule('install')->defaultModuleDataInstallSequence;
            }
            //Insert data from application data manager.
            UsniAdaptor::app()->globalDataManager->loadDefaultData();
            $excludedModulesFromInstall = UsniAdaptor::app()->getModule('install')->excludedModulesFromDataInstall;
            foreach($modules as $key)
            {
                //If not excluded from data install
                if(!in_array($key, $excludedModulesFromInstall))
                {
                    $module = UsniAdaptor::app()->getModule($key);
                    $this->processDataInstall($module, $loadDemoData, $formDTO);
                }
            }
            $this->loadInstanceData($formDTO);
            $transaction->commit();
        }
        catch (\yii\db\Exception $e)
        {
            $transaction->rollback();
            throw $e;
        }
    }
    
    /**
     * Process data install
     * @param Module $module
     * @param bool $loadDemoData
     * @param InstallFormDTO $formDTO
     */
    protected function processDataInstall($module, $loadDemoData, $formDTO)
    {
        $key = $module->id;
        if(is_null($module->dataManager))
        {
            $dmPaths          = $module->dataManagerPath;
            foreach($dmPaths as $dmPath)
            {
                $dmPathAlias      = str_replace('\\', '/', $dmPath);
                $dmPathKey        = UsniAdaptor::getAlias($dmPathAlias);
                $managerClassName = ucfirst($key) . 'DataManager';
                $managerClass     = $dmPath . '\\' . $managerClassName;
                $rawPath          = $dmPathKey . DS . $managerClassName . '.php';
                if(file_exists($rawPath))
                {
                    $this->loadDefaultAndDemoData($managerClass, $loadDemoData, $formDTO, $key);
                }
            }
        }
        else
        {
            $dataManager  = $module->dataManager;
            $dmPathAlias  = str_replace('\\', '/', $dataManager);
            $managerClass = FileUtil::normalizePath(UsniAdaptor::getAlias($dmPathAlias) . '.php');
            if(file_exists($managerClass))
            {
                $this->loadDefaultAndDemoData($dataManager, $loadDemoData, $formDTO, $key);
            }
        }
    }
    
    /**
     * Load default and demo data
     * @param string $managerClass
     * @param bool $loadDemoData
     * @param InstallFormDTO $formDTO
     * @param string $key
     */
    private function loadDefaultAndDemoData($managerClass, $loadDemoData, $formDTO, $key)
    {
        $manager = new $managerClass(); 
        $manager->loadDefaultData();
        $formDTO->addMessage(UsniAdaptor::t('install', 'Default data added for module ' . $key));
        if($loadDemoData)
        {
            if(method_exists($managerClass, 'loadDemoData'))
            {
                $manager->loadDemoData();
                $formDTO->addMessage(UsniAdaptor::t('install', 'Demo data added for module ' . $key));
            }
        }
    }
    
    /**
     * Process final steps
     * @param InstallFormDTO $formDTO
     * @return void
     */
    public function processFinalSteps($formDTO)
    {
        $this->backupDatabase($formDTO);
        $this->writeConfigFile($formDTO);
        $installSettingsFile = FileUtil::normalizePath(UsniAdaptor::app()->getRuntimePath() . DS . 'install' . DS .  'settingsdata.bin');
        @unlink($installSettingsFile);
        UsniAdaptor::app()->configManager->insertOrUpdateConfiguration('application', 'installTime', date('Y-m-d H:i:s'));
        $formDTO->addMessage(UsniAdaptor::t('install', 'Installation completed sucessfully'));
    }

    /**
     * Get install environments.
     * @return array
     */
    public function getEnvironments()
    {
        return [
                    'dev'           => UsniAdaptor::t('install', 'Development'),
                    'staging'       => UsniAdaptor::t('install', 'Staging'),
                    'production'    => UsniAdaptor::t('install', 'Production')
               ];
    }

    /**
     * Get available themes.
     * @return array
     */
    public function getAvailableThemes()
    {
        $data = [];
        if(file_exists(APPLICATION_PATH . '/themes'))
        {
            $dirIterator = new \DirectoryIterator(APPLICATION_PATH . '/themes');
            foreach ($dirIterator as $info)
            {
                $file = $info->getFilename();
                if($info->isDot())
                {
                    continue;
                }
                if($info->isDir() && $file !== '.svn' && $file !== '.hg')
                {
                    $data[$file] = $file;
                }
            }
        }
        return $data;
    }

    /**
     * Back up database
     * @param InstallFormDTO $formDTO
     * @return void
     */
    public function backupDatabase($formDTO)
    {
        $model          = $formDTO->getModel();
        $formDTO->addMessage(UsniAdaptor::t('install', 'Back up database starts'));
        $dbHost         = $model->dbHost;
        $dbUsername     = $model->dbUsername;
        $dbPassword     = $model->dbPassword;
        $dbPort         = $model->dbPort;
        $dbName         = $model->dbName;
        $basePath       = APPLICATION_PATH . '/data';
        $filePath       = $basePath . '/installdata.sql';
        DatabaseUtil::backupDatabase($dbHost,
                                     $dbUsername,
                                     $dbPassword,
                                     $dbPort,
                                     $dbName, $filePath);
        $formDTO->addMessage(UsniAdaptor::t('install', 'Back up database successfull'));
    }

    /**
     * Reload install data.
     */
    public static function reloadInstallData()
    {
        $dbHost     = UsniAdaptor::app()->configManager->getValue('application', 'dbHost');
        $dbUsername = UsniAdaptor::app()->configManager->getValue('application', 'dbUsername');
        $dbPassword = UsniAdaptor::app()->configManager->getValue('application', 'dbPassword');
        $dbPort     = UsniAdaptor::app()->configManager->getValue('application', 'dbPort');
        $dbName     = UsniAdaptor::app()->configManager->getValue('application', 'dbName');
        $basePath   = APPLICATION_PATH . '/data';
        $filePath   = FileUtil::normalizePath($basePath) . DS . 'installdata.sql';
        DatabaseUtil::restoreDatabase($dbHost,
                                     $dbUsername,
                                     $dbPassword,
                                     $dbPort,
                                     $dbName, $filePath);
    }
    
    /**
     * Build database tables.
     * @param InstallFormDTO $formDTO
     */
    public function buildTables($formDTO)
    {
        UsniAdaptor::db()->createCommand("SET foreign_key_checks = 0;")->execute();
        UsniAdaptor::db()->createCommand("SET CHARACTER SET utf8;")->execute();
        $modules        = UsniAdaptor::app()->moduleManager->getInstantiatedModules();
        //Build tables from application table manager.
        $appTableManager = new ApplicationTableManager();
        $appTableManager->buildTables();
        foreach($modules as $key => $module)
        {
            if($key == 'debug')
            {
                continue;
            }
            $managerClass   = $module->tableManager;
            $tmPath         = UsniAdaptor::getAlias('@' . str_replace('\\', '/', $managerClass)) . '.php';
            if(file_exists($tmPath))
            {
                //$this->addMessage(UsniAdaptor::t('install', 'Start creating tables for module ' . $key));
                $manager = new $managerClass();
                $manager->buildTables();
                $formDTO->addMessage(UsniAdaptor::t('install', 'Create tables for module ' . $key . ' is successful'));
            }
        }
    }
    
    /**
     * Process system check.
     * @return array
     */
    public function processCheckSystem()
    {
        $requirementsChecker = new ApplicationRequirementChecker();
        $requirements        = $requirementsChecker->getRequirements();
        return $requirementsChecker->checkYii()->check($requirements)->getResult();
    }
    
    /**
     * Process system check.
     * @param InstallFormDTO $formDTO
     */
    public function processSettings($formDTO)
    {
        $model      = new SettingsForm(['scenario' => $formDTO->getScenario()]);
        $postData   = $formDTO->getPostData();
        if(!empty($postData['SettingsForm']))
        {
            $model->attributes  = $postData['SettingsForm'];
            $uploadInstance     = UploadedFile::getInstance($model, 'logo');
            if($uploadInstance != null)
            {
                $model->logo = FileUploadUtil::getEncryptedFileName($uploadInstance->name);
            }
            if($model->validate())
            {
                if($model->logo != null)
                {
                    $config = [
                            'model'             => $model, 
                            'attribute'         => 'logo', 
                            'uploadInstance'    => $uploadInstance, 
                            'savedFile'         => null,
                            'thumbWidth'        => 500,
                            'thumbHeight'       => 500
                          ];
                    FileUploadUtil::save('image', $config);
                }
                $runTimePath = UsniAdaptor::app()->getRuntimePath();
                $data   = UsniAdaptor::app()->security->hashData(serialize($model->getAttributes()), self::INSTALL_KEY);
                $value  = base64_encode($data);
                FileUtil::createDirectory(FileUtil::normalizePath($runTimePath. DS . 'install'));
                FileUtil::writeFile(FileUtil::normalizePath($runTimePath. DS . 'install'), 'settingsdata.bin', 'wb', $value);
                $formDTO->setIsTransactionSuccess(true);
            }
        }
        $formDTO->setModel($model);
        $formDTO->setEnvironments($this->getEnvironments());
    }
    
    /**
     * Process run installation
     * @param InstallFormDTO $formDTO
     */
    public function processRunInstallation($formDTO)
    {
        $model      = new SettingsForm(['scenario' => $formDTO->getScenario()]);
        $settings   = $formDTO->getSettings();
        if(($data = base64_decode($settings)) !== false)
        {
            if(($data = UsniAdaptor::app()->security->validateData($data, self::INSTALL_KEY)) !== false)
            {
                $data = unserialize($data);
            }
            else
            {
                throw new \yii\base\InvalidConfigException();
            }
        }
        $model->attributes  = $data;
        $formDTO->setModel($model);
    }
    
    /**
     * Build database.
     * @param InstallFormDTO $formDTO
     */
    public function buildDatabase($formDTO)
    {
        $transaction    = UsniAdaptor::db()->beginTransaction();
        try
        {
            $basePath = APPLICATION_PATH . '/data';
            DatabaseUtil::removeTablesFromDatabase();
            $formDTO->addMessage(UsniAdaptor::t('install', 'Remove tables from database'));
            $this->buildTables($formDTO);
            //Check if instance sql exists or not.
            $databaseInstanceFile = $basePath . '/instancedb.sql';
            if(file_exists($databaseInstanceFile))
            {
                $sql  = file_get_contents($databaseInstanceFile);
                if(!empty($sql))
                {
                    UsniAdaptor::db()->createCommand($sql)->execute();
                }
            }
            $transaction->commit();
            UsniAdaptor::db()->getSchema()->refresh();
        }
        catch (\yii\db\Exception $e)
        {
            $transaction->rollback();
            throw $e;
        }
    }
}