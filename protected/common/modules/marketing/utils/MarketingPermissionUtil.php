<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\marketing\utils;

use usni\library\utils\PermissionUtil;
use usni\UsniAdaptor;
/**
 * MarketingPermissionUtil class file.
 * @package common\modules\marketing\utils
 */
class MarketingPermissionUtil extends PermissionUtil
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
        return 'marketing';
    }

    /**
     * @inheritdoc
     */
    public static function getPermissions()
    {
        $permissions    = array();
        $permissions['MarketingModule'] = [
                                                'access.marketing'  => UsniAdaptor::t('application', 'Access Tab'),
                                                'marketing.mail'    => UsniAdaptor::t('marketing', 'Marketing Mails'),
                                          ];
        return $permissions;
    }
}
?>