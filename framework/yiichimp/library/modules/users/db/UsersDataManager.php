<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\users\db;

use usni\library\db\DataManager;
use usni\library\modules\users\models\User;
use usni\UsniAdaptor;
/**
 * UsersDataManager class file.
 * 
 * @package usni\library\modules\users\db
 */
class UsersDataManager extends DataManager
{
    /**
     * @inheritdoc
     */
    public function loadDefaultData()
    {
        UsniAdaptor::app()->configManager->insertOrUpdateConfiguration('users', 'passwordTokenExpiry', 3600);
        $this->saveNotificationTemplate();
        return true;
    }
    
    /**
     * @inheritdoc
     */
    public function loadDemoData()
    {
        return [];
    }
    
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return User::className();
    }
    
    /**
     * inheritdoc
     */
    public function getNotificationDataSet()
    {
        $basePath   = UsniAdaptor::app()->getModule('users')->basePath;
        return  [
                    [
                            'type'      => 'email',
                            'notifykey' => User::NOTIFY_CREATEUSER,
                            'subject'   => UsniAdaptor::t('users', 'New User Registration'),
                            'content'   => file_get_contents($basePath . '/email/_newUser.php')
                    ],
                    [
                            'type'      => 'email',
                            'notifykey' => User::NOTIFY_CHANGEPASSWORD,
                            'subject'   => UsniAdaptor::t('users', 'You have changed your password'),
                            'content'   => file_get_contents($basePath . '/email/_changePassword.php')
                    ],
                    [
                            'type'      => 'email',
                            'notifykey' => User::NOTIFY_FORGOTPASSWORD,
                            'subject'   => UsniAdaptor::t('users', 'Forgot Password Request'),
                            'content'   => file_get_contents($basePath . '/email/_forgotPassword.php')
                    ]
                ];
    }
}
