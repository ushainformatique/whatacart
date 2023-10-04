<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\settings;

use usni\library\components\SecuredModule;
use usni\UsniAdaptor;
/**
 * Provides functionality related to settings in the system.
 * 
 * @package usni\library\modules\settings
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
        UsniAdaptor::app()->i18n->translations['settings*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@approot/messages'
        ];
        UsniAdaptor::app()->i18n->translations['settingshint*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@approot/messages'
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function getPermissions()
    {
        $permissions['SettingsModule'] = ['access.settings' => UsniAdaptor::t('application', 'Access Tab'),
                                          'settings.email'  => UsniAdaptor::t('settings', 'Email Settings'),
                                          'settings.site'   => UsniAdaptor::t('settings', 'Site Settings'),
                                          'settings.database' => UsniAdaptor::t('settings', 'Database Settings')];
        return $permissions;
    }
}
