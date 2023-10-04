<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\users;

use usni\library\components\SecuredModule;
use usni\library\modules\users\models\User;
use usni\UsniAdaptor;

/**
 * Loads the users module in the system.
 * 
 * @package usni\library\modules\users
 */
class Module extends SecuredModule
{
    public $controllerNamespace = 'usni\library\modules\users\controllers';

    /**
     * Overrides to register translations.
     */
    public function init()
    {
        parent::init();
        $this->registerTranslations();
    }

    /**
     * Registers translations.
     */
    public function registerTranslations()
    {
        UsniAdaptor::app()->i18n->translations['users*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@approot/messages'
        ];
        UsniAdaptor::app()->i18n->translations['userflash*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@approot/messages'
        ];
        UsniAdaptor::app()->i18n->translations['userhint*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@approot/messages'
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function getPermissionModels()
    {
        return [User::className()];
    }
    
    /**
     * @inheritdoc
     */
    public function getModelToExcludedPermissions()
    {
         return [User::className() => ['bulkdelete']];
    }
    
    /**
     * @inheritdoc
     */
    public function getPermissions()
    {
        $permissions = parent::getPermissions();
        $permissions['User']['user.change-password']    = UsniAdaptor::t('users', 'Change Password');
        $permissions['User']['user.change-status']      = UsniAdaptor::t('users', 'Change Status');
        $permissions['User']['user.settings']           = UsniAdaptor::t('settings', 'Settings');
        $permissions['User']['user.change-passwordother'] = UsniAdaptor::t('users', 'Change Others Password');
        return $permissions;
    }
}