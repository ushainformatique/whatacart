<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\stores\managers;

use common\modules\stores\models\Store;
use usni\library\managers\BaseMenuManager;
/**
 * MenuManager class file.
 * @package common\modules\stores\managers
 */
class MenuManager extends BaseMenuManager
{
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return Store::className();
    }
    
    /**
     * @inheritdoc
     */
    public static function getIcon()
    {
        return 'globe';
    }
    
    /**
     * @inheritdoc
     */
    public static function getModuleUniqueId()
    {
        return 'stores';
    }
}