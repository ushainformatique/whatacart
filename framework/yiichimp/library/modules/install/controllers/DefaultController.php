<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\install\controllers;

use usni\UsniAdaptor;
use usni\library\modules\install\components\OutputBufferStreamer;
use usni\library\utils\Html;
use usni\library\utils\FileUtil;
use usni\library\modules\install\business\InstallManager;
use usni\library\modules\install\dto\InstallFormDTO;
/**
 * DefaultController for the install module.
 * 
 * @package usni\library\modules\install\controllers
 */
class DefaultController extends \usni\library\web\Controller
{
    /**
     * View file for the welcome screen
     * @var string
     */
    public $welcomeViewFile = '/welcome';
    
    /**
     * Title for the view screens during install
     * @var type 
     */
    public $title;
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [];
    }
    
    /**
     * inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->getView()->bodyClass = 'full-width';
        $this->getView()->title     = UsniAdaptor::t('application', 'Installation');
    }

    /**
     * Runs the installation.
     * @return void
     */
    public function actionIndex()
    {
        UsniAdaptor::app()->user->switchIdentity(null);
        UsniAdaptor::app()->getSession()->destroy();
        return $this->render($this->welcomeViewFile);
    }
    
    /**
     * Checks system.
     * @return void
     */
    public function actionCheckSystem()
    {
        $installManager = new InstallManager();
        $systemResults  = $installManager->processCheckSystem();
        return $this->render('/requirements', [
                                                       'requirements' => $systemResults['requirements'],
                                                       'summary'      => $systemResults['summary']
                                              ]);
    }

    /**
     * Load settings.
     * @return void
     */
    public function actionSettings()
    {
        $formDTO    = new InstallFormDTO();
        $formDTO->setScenario('create');
        $postData   = UsniAdaptor::app()->request->post();
        $formDTO->setPostData($postData);
        $installManager = new InstallManager();
        $installManager->processSettings($formDTO);
        if($formDTO->getIsTransactionSuccess())
        {
            $url    = UsniAdaptor::createUrl('/install/default/run-installation');
            return $this->redirect($url);
        }
        return $this->render('/settings', ['formDTO' => $formDTO]);
    }
    
    /**
     * Runs installation.
     * @param string $settings
     * @return void
     */
    public function actionRunInstallation()
    {
        $settings           = file_get_contents(FileUtil::normalizePath(UsniAdaptor::app()->getRuntimePath() . DS . 'install' . DS .  'settingsdata.bin'));
        $formDTO            = new InstallFormDTO();
        $formDTO->setScenario('create');
        $formDTO->setSettings($settings);
        $installManager     = new InstallManager();
        $installManager->processRunInstallation($formDTO);
        echo $this->render('/final');
        
        $template           = Html::script("$('#progress-messages').prepend('{message}<br/>');");
        $progressTemplate   = Html::script("$('.install-progress').html('{message}%');
                                             $('.progress-bar').attr('aria-valuenow', '{message}');
                                             $('.progress-bar').attr('style', 'width:{message}%');");
        $obRenderer         = new OutputBufferStreamer($template, $progressTemplate);
        
        ob_implicit_flush(true);
        $obRenderer->add(UsniAdaptor::t('install', 'Begin Installation'));
        
        //Sets time limit
        @set_time_limit(1800);
        $obRenderer->add(UsniAdaptor::t('install', 'Set time limit for execution to') . ' 1800');
        
        try
        {
            $formDTO->setConfigFile('instance.php');
            $installManager->setConfigFiles($formDTO);
            $installManager->setDbComponent($formDTO);
            //Build database
            $obRenderer->add(UsniAdaptor::t('install', 'Start building database'));
            //Build database call
            $installManager->buildDatabase($formDTO);
            $this->outputMessages($obRenderer, $formDTO);
            
            //Render messages here
            $obRenderer->add(UsniAdaptor::t('install', 'Database creation successfull'));
            $obRenderer->addProgressMessage('50');
            
            //Save configuration in db
            $installManager->saveSettingsInDatabase($formDTO);
            $obRenderer->add(UsniAdaptor::t('install', 'Configuration saved successfully'));
            $obRenderer->addProgressMessage('55');
            
            //Add super user
            $installManager->createSuperUser($formDTO);
            $obRenderer->add(UsniAdaptor::t('install', 'Super user created successfully'));
            $obRenderer->addProgressMessage('60');
            //Add permissions
            $obRenderer->add(UsniAdaptor::t('install', 'Start loading module permissions'));
            $installManager->loadPermissions();
            $obRenderer->add(UsniAdaptor::t('install', 'Module permissions loaded successfully'));
            $obRenderer->addProgressMessage('65');
            
            //Install data
            $installManager->installDefaultAndDemoData($formDTO);
            $this->outputMessages($obRenderer, $formDTO);
            $obRenderer->addProgressMessage('80');
            
            //Final steps
            $installManager->processFinalSteps($formDTO);
            $this->outputMessages($obRenderer, $formDTO);
            $obRenderer->addProgressMessage('100');
            $template           = Html::script("$('#progress-container').hide();$('#final-overview').removeClass('hide').addClass('show');");
            $obRenderer->setTemplate($template);
            $obRenderer->add('');
        } 
        catch (\yii\db\Exception $e) 
        {
            //Output what should be echoed by now
            $this->outputMessages($obRenderer, $formDTO);
            $template           = Html::script("$('#progress-container').hide();
                                                  $('#install-errors').removeClass('hide').addClass('show');");
            $obRenderer->setTemplate($template);
            $obRenderer->add('');
            echo $e->getMessage();
            UsniAdaptor::app()->end();
        }
        catch(\yii\base\InvalidConfigException $ex)
        {
            //Output what should be echoed by now
            $this->outputMessages($obRenderer, $formDTO);
            $template           = Html::script("$('#progress-container').hide();
                                                  $('#install-errors').removeClass('hide').addClass('show');
                                                  $('#error-messages').html('{message}');");
            $obRenderer->setTemplate($template);
            $obRenderer->add($ex->getMessage());
            UsniAdaptor::app()->end();
        }
    }
    
    /**
     * Output messages
     * @param OutputBufferStreamer $obRenderer
     * @param InstallFormDTO $formDTO
     */
    private function outputMessages($obRenderer, $formDTO)
    {
        $messages   = $formDTO->getMessages();
        foreach($messages as $message)
        {
            $obRenderer->add($message);
        }
    }
}