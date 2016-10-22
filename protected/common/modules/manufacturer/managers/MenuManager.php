<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\manufacturer\managers;

use common\modules\manufacturer\models\Manufacturer;
use usni\library\managers\BaseMenuManager;
use usni\UsniAdaptor;
/**
 * MenuManager class file.
 * @package common\modules\customer\managers
 */
class MenuManager extends BaseMenuManager
{
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return Manufacturer::className();
    }
    
    /**
     * @inheritdoc
     */
    public static function getIcon()
    {
        return 'home';
    }
    
    /**
     * @inheritdoc
     */
    public static function getModuleUniqueId()
    {
        return 'manufacturer';
    }
    
    /**
     * @inheritdoc
     */
    public static function getSidebarHeader()
    {
        return UsniAdaptor::t('catalog', 'Catalog');
    }
}