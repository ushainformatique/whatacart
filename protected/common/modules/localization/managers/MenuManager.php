<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\localization\managers;

use usni\UsniAdaptor;
use usni\library\modules\auth\managers\AuthManager;
use usni\library\utils\ArrayUtil;
use usni\library\utils\AdminUtil;
/**
 * MenuManager class file.
 * 
 * @package common\modules\localization\managers
 */
class MenuManager extends \usni\library\managers\BaseModuleWithSubModulesMenuManager
{
    /**
     * @inheritdoc
     */
    public static function getModuleId()
    {
        return 'localization';
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
        if (AuthManager::checkAccess($user, 'access.localization'))
        {
            $items['sidebar'] = [
                [
                    'label'       =>  AdminUtil::wrapSidebarMenuLabel(UsniAdaptor::t('localization', 'Localization')),
                    'itemOptions' => ['class' => 'navblock-header'],
                    'url'         => '#',
                    'items'       => $sidebarItems
                ]
            ];
        }
        else
        {
            $items['sidebar'] = [];
        }
    }
    
    /**
     * @inheritdoc
     */
    public static function getCreateItems(& $items)
    {
        $items['create'] = [];
    }
    
    /**
     * @inheritdoc
     */
    public static function getManageItems(& $items)
    {
        $items['manage'] = [];
    }
    
    /**
     * @inheritdoc
     */
    public static function getSidebarHeader()
    {
        return UsniAdaptor::t('application', 'System');
    }
}