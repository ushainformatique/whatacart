<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\catalog\managers;

use usni\UsniAdaptor;
use usni\library\modules\auth\managers\AuthManager;
use usni\library\utils\ArrayUtil;
use usni\library\components\AdminMenuRenderer;
use usni\library\utils\AdminUtil;
/**
 * MenuManager class file.
 * @package common\modules\catalog\managers
 */
class MenuManager extends \usni\library\managers\BaseModuleWithSubModulesMenuManager
{
    /**
     * @inheritdoc
     */
    public static function getModuleId()
    {
        return 'catalog';
    }
    
    /**
     * @inheritdoc
     */
    public static function getSidebarItems(& $items)
    {
        $user           = UsniAdaptor::app()->user->getUserModel();
        $sidebarItems   = [];
        $subModuleItems = static::getSubModuleItems();
        foreach($subModuleItems as $subModuleId => $menuItems)
        {
            if(ArrayUtil::getValue($menuItems, 'sidebar') !== null)
            {
                $sidebarItems   = ArrayUtil::merge($sidebarItems, $menuItems['sidebar']);
            }
        }
        if (AuthManager::checkAccess($user, 'access.catalog'))
        {
            $items ['sidebar'] = [
                [
                    'label' =>  AdminMenuRenderer::getSidebarMenuIcon('shopping-cart') .
                                AdminUtil::wrapSidebarMenuLabel(UsniAdaptor::t('catalog', 'Catalog')),
                    'itemOptions' => ['class' => 'navblock-header'],
                    'url' => '#',
                    'items' => $sidebarItems
                ]
            ];
        }
        return $items;
    }
}