<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\auth;

use usni\library\components\SecuredModule;
use usni\UsniAdaptor;
use usni\library\modules\auth\models\Group;
/**
 * Provides functionality related to authorization in the system.
 * 
 * @package usni\library\modules\auth
 */
class Module extends SecuredModule
{
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
        UsniAdaptor::app()->i18n->translations['auth*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@approot/messages',
        ];
        UsniAdaptor::app()->i18n->translations['authhint*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@approot/messages',
        ];
        UsniAdaptor::app()->i18n->translations['authflash*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@approot/messages',
        ];
    }
    
    /**
     * inheritdoc
     */
    public function getPermissionModels()
    {
        return [Group::className()];
    }
    
    /**
     * @inheritdoc
     */
    public function getPermissions()
    {
        $permissions = parent::getPermissions();
        $permissions['AuthModule']['auth.managepermissions'] = UsniAdaptor::t('auth', 'Manage Permissions');
        return $permissions;
    }
}