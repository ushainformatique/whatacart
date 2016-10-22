<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\order\managers;

use common\modules\order\models\Order;
use usni\library\managers\BaseMenuManager;
use usni\UsniAdaptor;
/**
 * MenuManager class file.
 * @package common\modules\order\managers
 */
class MenuManager extends BaseMenuManager
{
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return Order::className();
    }
    
    /**
     * @inheritdoc
     */
    public static function getIcon()
    {
        return 'suitcase';
    }
    
    /**
     * @inheritdoc
     */
    public static function getModuleUniqueId()
    {
        return 'order';
    }
    
    /**
     * @inheritdoc
     */
    public static function getSidebarHeader()
    {
        return UsniAdaptor::t('application', 'Sales');
    }
}