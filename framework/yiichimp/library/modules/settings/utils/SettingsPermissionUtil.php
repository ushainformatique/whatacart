<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\settings\utils;

use usni\library\utils\PermissionUtil;
use usni\UsniAdaptor;
/**
 * SettingsPermissionUtil class file.
 * @package usni\library\modules\service\utils
 */
class SettingsPermissionUtil extends PermissionUtil
{
    /**
     * @inheritdoc
     */
    public static function getModels()
    {
        return [];
    }
    
    /**
     * @inheritdoc
     */
    public static function getModuleId()
    {
        return 'settings';
    }

    /**
     * @inheritdoc
     */
    public static function getPermissions()
    {
        $permissions    = array();
        $permissions['SettingsModule'] = ['access.settings' => UsniAdaptor::t('application', 'Access Tab'),
                                          'settings.email'  => UsniAdaptor::t('settings', 'Email Settings'),
                                          'settings.site'   => UsniAdaptor::t('settings', 'Site Settings'),
                                          'settings.database'   => UsniAdaptor::t('settings', 'Database Settings'),
                                          'settings.menu'       => UsniAdaptor::t('settings', 'Menu Settings'),
                                          'settings.admin-menu' => UsniAdaptor::t('settings', 'Admin Menu Settings'),
                                          'settings.module-settings' => UsniAdaptor::t('settings', 'Module Settings'),
                                          'settings.database' => UsniAdaptor::t('settings', 'Database Settings')];
        return $permissions;
    }
}
?>