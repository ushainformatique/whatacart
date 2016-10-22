<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\marketing\managers;

use usni\UsniAdaptor;
use usni\library\utils\ArrayUtil;
use usni\library\components\AdminMenuRenderer;
use usni\library\utils\AdminUtil;
use usni\library\modules\auth\managers\AuthManager;
/**
 * MenuManager class file.
 * @package common\modules\marketing\managers
 */
class MenuManager extends \usni\library\managers\BaseModuleWithSubModulesMenuManager
{
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
    public static function getSidebarItems(& $items)
    {
        $user           = UsniAdaptor::app()->user->getUserModel();
        $sidebarItems   = [
                                [
                                    'label'     => AdminUtil::wrapSidebarMenuLabel(UsniAdaptor::t('marketing', 'Mails')),
                                    'url'       => ['/marketing/send-mail/create'],
                                    'visible'   => AuthManager::checkAccess($user, 'marketing.mail'),
                                ]
                          ];
        $subModuleItems = static::getSubModuleItems();
        foreach($subModuleItems as $subModuleId => $menuItems)
        {
            if(ArrayUtil::getValue($menuItems, 'sidebar') !== null)
            {
                $sidebarItems   = ArrayUtil::merge($sidebarItems, $menuItems['sidebar']);
            }
        }
        if (AuthManager::checkAccess($user, 'access.marketing'))
        {
            $items ['sidebar'] = [
                [
                    'label' =>  AdminMenuRenderer::getSidebarMenuIcon('share') .
                                AdminUtil::wrapSidebarMenuLabel(UsniAdaptor::t('marketing', 'Marketing')),
                    'itemOptions' => ['class' => 'navblock-header'],
                    'url' => '#',
                    'items' => $sidebarItems
                ]
            ];
        }
        return $items;
    }
}