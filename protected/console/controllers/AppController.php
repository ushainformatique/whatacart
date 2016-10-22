<?php
namespace console\controllers;

use yii\console\Controller;
use usni\library\modules\install\components\InstallManager;
use usni\library\modules\install\models\SettingsForm;
use usni\UsniAdaptor;
use usni\library\components\OutputBufferStreamer;
/**
 * Run database related action and install the application
 *
 * The command would be as follows yii app/build
 * @package console\controllers
 */
class AppController extends Controller
{
    /**
     * Database admin username.
     * @var string
     */
    public $dbAdminUsername;
    /**
     * Database admin password
     * @var string
     */
    public $dbAdminPassword;
    /**
     * Store sitename.
     * @var string
     */
    public $siteName;
    /**
     * Store description.
     * @var string
     */
    public $siteDescription;
    /**
     * Store super username.
     * @var string
     */
    public $superUsername;
    /**
     * Store admin email.
     * @var string
     */
    public $superEmail;

    /**
     * Store admin password.
     * @var string
     */
    public $superPassword;
    /**
     * Store db host.
     * @var string
     */
    public $dbHost = 'localhost';
    /**
     * Store db host.
     * @var integer
     */
    public $dbPort = 3306;
    /**
     * Store db name.
     * @var string
     */
    public $dbName;
    /**
     * Store db username.
     * @var string
     */
    public $dbUsername;
    /**
     * Store db password.
     * @var string
     */
    public $dbPassword;
    /**
     * Site environment.
     * @var string
     */
    public $environment;
    /**
     * Front end theme.
     * @var string
     */
    public $frontTheme;
    /**
     * Site demo data.
     * @var string
     */
    public $demoData = 1;
    /**
     * site timezone.
     * @var string
     */
    public $timezone;
    /**
     * site logo.
     * @var string
     */
    public $logo;
    
    
    
    /**
     * @inheritdoc
     */
    public function options($actionID)
    {
        return array_merge(
            parent::options($actionID),
            ['dbName', 'dbUsername', 'dbPassword'] // global for all actions
        );
    }
    
    /**
     * Rebuild the database. This command would be executed only if app is installed
     */
    public function actionBuild()
    {
        if(!UsniAdaptor::app()->isInstalled())
        {
            $obRenderer         = new OutputBufferStreamer();
            $this->dbName = $this->prompt("Enter Database Name:", ['required' => true]);
            $this->dbUsername = $this->prompt("Enter Database Username:", ['required' => true]);
            $this->dbPassword = $this->prompt("Enter Database Password:", ['required' => true]);
            $this->siteName = $this->prompt("Enter Site Name:", ['required' => true, 'default' => 'Default Store']);
            $this->siteDescription = $this->prompt("Enter Site Description:", ['required' => true, 'default' => 'Default Store Description']);
            $this->superUsername = $this->prompt("Enter Super Username:", ['required' => true, 'default' => 'super']);
            $this->superPassword = $this->prompt("Enter Super Password:", ['required' => true, 'default' => 'admin']);
            $this->superEmail = $this->prompt("Enter Super Email:", ['required' => true]);
            $this->frontTheme = $this->prompt("Enter Front Theme:", ['required' => true, 'default' => 'classic']);
            $this->timezone   = $this->prompt("Enter timezone for e.g. Asia/Kolkata:", ['required' => true, 'default' => 'Asia/Kolkata']);
            $this->environment = $this->select("Select environment:", ['test' => 'Test', 'prod' => 'Production', 'dev' => 'Development']);
            $installModel = new SettingsForm(['dbName' => $this->dbName, 
                                              'dbUsername' => $this->dbUsername, 
                                              'dbPassword' => $this->dbPassword,
                                              'dbAdminUsername' => '',
                                              'dbAdminPassword' => '',
                                              'siteName'        => $this->siteName,
                                              'siteDescription' => $this->siteDescription,
                                              'superUsername'   => $this->superUsername,
                                              'superEmail'      => $this->superEmail,
                                              'superPassword'   => $this->superPassword,
                                              'frontTheme'      => $this->frontTheme,
                                              'timezone'        => $this->timezone,
                                              'environment'     => $this->environment,
                                              'logo'            => '']);
            $manager = new InstallManager(['showBufferMessage' => false]);
            $manager->runInstallation($installModel, $obRenderer, 'instance.php');
        }
    }
}