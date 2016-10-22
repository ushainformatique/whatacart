<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\stores\utils;

use usni\library\utils\PermissionUtil;
use common\modules\stores\models\Store;

/**
 * StoresPermissionUtil class file.
 * 
 * @package common\modules\stores\utils
 */
class StoresPermissionUtil extends PermissionUtil
{
    /**
     * Gets models associated to the stores module.
     * @return array
     */
    public static function getModels()
    {
        return [
                    Store::className()
               ];
    }

    /**
     * @inheritdoc
     */
    public static function getModuleId()
    {
        return 'stores';
    }
    
    /**
     * @inheritdoc
     */
    public static function getPermissions()
    {
        $permissions = parent::getPermissions();
        unset($permissions['Store']['store.bulk-delete']);
        return $permissions;
    }
}