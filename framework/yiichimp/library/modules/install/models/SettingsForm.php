<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\install\models;

use usni\library\utils\DatabaseUtil;
use usni\UsniAdaptor;
/**
 * SettingsForm is the data structure for keeping install dynamic information.
 * 
 * @package usni\library\modules\install\models
 */
class SettingsForm extends \yii\base\Model
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
     * Upload File Instance.
     * @var string
     */
    public $uploadInstance;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                  [['siteName', 'siteDescription', 'superUsername', 'superEmail', 'superPassword', 'dbHost', 'dbPort', 'dbName', 
                    'dbUsername', 'dbPassword', 'environment', 'timezone'], 'required'],
                  [['siteName', 'siteDescription', 'superUsername', 'superEmail', 'superPassword', 'dbHost', 'dbName', 'dbUsername', 
                    'dbPassword', 'dbAdminUsername', 'dbAdminPassword', 'environment', 'logo'], 'string'],
                    ['superUsername',      'string', 'min'    => 3],
                    ['superUsername',      'match', 'pattern' => '/^[A-Z0-9._]+$/i'],
                    ['dbPort',             'integer'],
                    [['logo', 'uploadInstance'], 'image', 'skipOnEmpty' => true, 'extensions' => 'jpg, png, gif'],
                    ['superEmail',         'match', 'pattern' => '/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i'],
                    [['demoData'], 'safe']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenario            = parent::scenarios();
        $scenario['create']  = ['siteName', 'siteDescription', 'superUsername', 'superEmail', 'superPassword', 'dbHost', 'dbPort', 'dbName', 
                                'dbUsername', 'dbPassword', 'environment', 'dbAdminUsername', 'dbAdminPassword', 'timezone', 'logo', 
                                'demoData'];
        return $scenario;
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
                    'siteName'        => UsniAdaptor::t('application', 'Site Name'),
                    'siteDescription' => UsniAdaptor::t('application', 'Site Description'),
                    'superUsername'   => UsniAdaptor::t('users', 'Super Username'),
                    'superEmail'      => UsniAdaptor::t('users', 'Super User Email'),
                    'superPassword'   => UsniAdaptor::t('users', 'Super User Password'),
                    'dbAdminUsername' => UsniAdaptor::t('users', 'Database Admin User Name'),
                    'dbAdminPassword' => UsniAdaptor::t('users', 'Database Admin Password'),
                    'dbHost'          => UsniAdaptor::t('install', 'Database Host'),
                    'dbPort'          => UsniAdaptor::t('install', 'Database Port'),
                    'dbName'          => UsniAdaptor::t('install', 'Database Name'),
                    'dbUsername'      => UsniAdaptor::t('install', 'Database Username'),
                    'dbPassword'      => UsniAdaptor::t('install', 'Database Password'),
                    'environment'     => UsniAdaptor::t('application', 'Environment'),
                    'demoData'        => UsniAdaptor::t('install', 'Install Demo Data'),
                    'timezone'        => UsniAdaptor::t('users', 'Timezone'),
                    'logo'            => UsniAdaptor::t('install', 'Logo')
               ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
                    'siteName'        => UsniAdaptor::t('applicationhint', 'Name of the site'),
                    'siteDescription' => UsniAdaptor::t('applicationhint', 'Description for the site'),
                    'superUsername'   => UsniAdaptor::t('userhint', 'Super User Name for the site'),
                    'superEmail'      => UsniAdaptor::t('userhint', 'Letters, numbers & periods are allowed with a mail server name. eg test@yahoo.com'),
                    'superPassword'   => UsniAdaptor::t('userhint', 'Super Administrator password'),
                    'dbHost'          => UsniAdaptor::t('installhint', 'Database Host'),
                    'dbPort'          => UsniAdaptor::t('installhint', 'Database Port'),
                    'dbName'          => UsniAdaptor::t('installhint', 'Database Name'),
                    'dbUsername'      => UsniAdaptor::t('installhint', 'Database Username'),
                    'dbPassword'      => UsniAdaptor::t('installhint', 'Database Password'),
                    'dbAdminUsername' => UsniAdaptor::t('userhint', 'Super administrator username for the database'),
                    'dbAdminPassword' => UsniAdaptor::t('userhint', 'Super administrator password for the database'),
                    'environment'     => UsniAdaptor::t('applicationhint', 'Application environment whether development, stage or production'),
                    'demoData'        => UsniAdaptor::t('installhint', 'Install Demo Data'),
                    'logo'            => UsniAdaptor::t('installhint', 'Site Logo'),
               ];
    }

    /**
     * @inheritdoc
     */
    public function afterValidate()
    {
        parent::afterValidate();
        if (count($this->getErrors()) == 0)
        {
            if($this->dbAdminUsername != null)
            {
                //TODO @Mayank Enable it in production
                /*if ($this->dbAdminPassword == null)
                {
                    $this->addError('dbAdminPassword', UsniAdaptor::t('install', 'Administrative password is required as ' .
                    'you provided admin user name'));
                    return;
                }*/
                if($this->processAndCheckDbConnection() === false)
                {
                    return;
                }
                
                if($this->processAndCheckDatabase(true) === false)
                {
                    return;
                }
                if($this->processAndCheckDatabaseUser() === false)
                {
                    return;
                }
            }
            else
            {
                if($this->processAndCheckDbConnection() === false)
                {
                    return;
                }
                if($this->processAndCheckDatabase() === false)
                {
                    return;
                }
            }
        }
    }

    /**
     * Process and check db connection.
     * @return void
     */
    protected function processAndCheckDbConnection()
    {
        if($this->dbAdminUsername != null)
        {
            $username = $this->dbAdminUsername;
            $password = $this->dbAdminPassword;
        }
        else
        {
            $username = $this->dbUsername;
            $password = $this->dbPassword;
        }
        $connectionResult = DatabaseUtil::checkDbConnection($this->dbHost,
                                                            $username,
                                                            $password,
                                                            (int) $this->dbPort);
        if ($connectionResult !== true)
        {
            $this->addError('dbUsername', UsniAdaptor::t('application', 'Error Code') . ": " .
                                    $connectionResult[0] . "<br/>"  . UsniAdaptor::t('application', 'Message') . ":" . $connectionResult[1]);
            return false;
        }
        return true;
    }

    /**
     * Process and check db.
     * @param $createNew bool
     * @return void
     */
    protected function processAndCheckDatabase($createNew = false)
    {
        if($this->dbAdminUsername != null)
        {
            $username = $this->dbAdminUsername;
            $password = $this->dbAdminPassword;
        }
        else
        {
            $username = $this->dbUsername;
            $password = $this->dbPassword;
        }
        $databaseExistsResult = DatabaseUtil::checkDatabaseExists($this->dbHost,
                                                                  $username,
                                                                  $password,
                                                                  (int) $this->dbPort,
                                                                  $this->dbName);
        if ($databaseExistsResult !== true)
        {
            if($createNew === true)
            {
                $isDbCreated = DatabaseUtil::createDatabase($this->dbHost,
                                                            $username,
                                                            $password,
                                                            (int) $this->dbPort,
                                                            $this->dbName);
                if($isDbCreated !== true)
                {
                    $message = 
                    $this->addError('dbName', UsniAdaptor::t('install', 'There was a problem creating the database') .
                        " " . UsniAdaptor::t('application', 'Error Code') . ": " . $databaseExistsResult[0] . 
                        ". \n" .  UsniAdaptor::t('application', 'Message') . ": " . $databaseExistsResult[1]);
                    return false;
                }
                else
                {
                    return true;
                }
            }
            $this->addError('dbName', UsniAdaptor::t('install', 'The database does not exist or the user does not exist ') .
                        " " . UsniAdaptor::t('application', 'Error Code') . ": " . $databaseExistsResult[0] . 
                        ". \n" .  UsniAdaptor::t('application', 'Message') . ": " . $databaseExistsResult[1]);
            return false;
        }
        return true;
    }

    /**
     * Process and check db user.
     * @return void
     */
    protected function processAndCheckDatabaseUser()
    {
        $userExistsResult = DatabaseUtil::checkDatabaseUserExists($this->dbHost,
                                                                  $this->dbAdminUsername,
                                                                  $this->dbAdminPassword,
                                                                  (int) $this->dbPort,
                                                                  $this->dbUsername);
        if ($userExistsResult === false)
        {
            $userCreatedResult = DatabaseUtil::createDatabaseUser($this->dbHost,
                                                              $this->dbAdminUsername,
                                                              $this->dbAdminPassword,
                                                              (int) $this->dbPort,
                                                              $this->dbName,
                                                              $this->dbUsername,
                                                              $this->dbPassword);
            if($userCreatedResult !== true)
            {
                $this->addError('dbUsername', UsniAdaptor::t('install', 'There was a problem creating the user ') .
                    " " . UsniAdaptor::t('application', 'Error Code') . ": " . $userCreatedResult[0] . 
                        ". \n" .  UsniAdaptor::t('application', 'Message') . ": " . $userCreatedResult[1]);
                return false;
            }
        }
        else
        {
            $previligesResult = DatabaseUtil::grantDatabaseUserPreviliges($this->dbHost,
                                                                            $this->dbAdminUsername,
                                                                            $this->dbAdminPassword,
                                                                            (int) $this->dbPort,
                                                                            $this->dbName,
                                                                            $this->dbUsername,
                                                                            $this->dbPassword);
            if($previligesResult !== true)
            {
                $this->addError('dbUsername', UsniAdaptor::t('install', 'There was a problem assigning the previliges to the user ' .
                    'on database ' . $this->dbName ) . " " . UsniAdaptor::t('application', 'Error Code') . ": " . $previligesResult[0] . 
                        ". \n" .  UsniAdaptor::t('application', 'Message') . ": " . $previligesResult[1]);
                return false;
            }
        }
        return true;
    }
}