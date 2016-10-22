<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace newsletter\utils;

use usni\library\utils\PermissionUtil;
use newsletter\models\Newsletter;
/**
 * NewsletterPermissionUtil class file.
 * @package newsletter\utils;
 */
class NewsletterPermissionUtil extends PermissionUtil
{
    /**
     * @inheritdoc
     */
    public static function getModels()
    {
        return [
                    Newsletter::className()
               ];
    }

    /**
     * @inheritdoc
     */
    public static function getModuleId()
    {
        return 'newsletter';
    }
    
    /**
     * @inheritdoc
     */
    public static function getPermissions()
    {
        $permissions = parent::getPermissions();
        unset($permissions['Newsletter']['newsletter.update']);
        unset($permissions['Newsletter']['newsletter.updateother']);
        unset($permissions['Newsletter']['newsletter.bulk-edit']);
        unset($permissions['Newsletter']['newsletter.bulk-delete']);
        return $permissions;
    }
}
?>