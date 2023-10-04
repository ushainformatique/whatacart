<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\service;

use usni\library\components\SecuredModule;
use usni\UsniAdaptor;
/**
 * Provides functionality related to services available in the system.
 * 
 * @package usni\library\modules\service
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
        UsniAdaptor::app()->i18n->translations['serviceflash*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@approot/messages'
        ];
        UsniAdaptor::app()->i18n->translations['service*'] = [
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
        $permissions['ServiceModule'] = ['access.service'  => UsniAdaptor::t('application', 'Access Tab'),
                                         'service.checksystem' => UsniAdaptor::t('service', 'System Configuration'),
                                         'service.rebuildpermissions' => UsniAdaptor::t('auth', 'Rebuild Permissions'),
                                         'service.rebuildmodulemetadata' => UsniAdaptor::t('auth', 'Rebuild module metadata')
                                        ];
        return $permissions;
    }
}