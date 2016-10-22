<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\order\utils;

use usni\library\utils\PermissionUtil;
use common\modules\order\models\Order;
use usni\library\modules\auth\managers\AuthManager;
/**
 * OrderPermissionUtil class file.
 * @package common\modules\order\utils
 */
class OrderPermissionUtil extends PermissionUtil
{
    /**
     * Gets models associated to the order module.
     * @return array
     */
    public static function getModels()
    {
        return [
                    Order::className(),
               ];
    }

    /**
     * @inheritdoc
     */
    public static function getModuleId()
    {
        return 'order';
    }
    
    /**
     * @inheritdoc
     */
    public static function doesUserHavePermissionToPerformAction($model, $user, $permission)
    {
        if($model['customer_id'] != $user->id)
        {
            return AuthManager::checkAccess($user, $permission);
        }
        return true;
    }
}
?>