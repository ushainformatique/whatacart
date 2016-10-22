<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\cms\managers;

use usni\UsniAdaptor;
use usni\library\modules\auth\managers\AuthManager;
use common\modules\cms\models\Page;
use usni\library\components\AdminMenuRenderer;
use usni\library\utils\AdminUtil;
/**
 * MenuManager class file.
 * 
 * @package common\modules\cms\managers
 */
class MenuManager extends \usni\library\managers\BaseMenuManager
{
    /**
     * Get sidebar items.
     * @param array $items
     */
    public static function getSidebarItems(& $items)
    {
        $items ['sidebar']   = [];
        $user  = UsniAdaptor::app()->user->getUserModel();
        if(AuthManager::checkAccess($user, 'access.cms'))
        {
            $items ['sidebar'] =    [
                                        [
                                        'label'       => AdminMenuRenderer::getSidebarMenuIcon('pencil') .
                                                         AdminUtil::wrapSidebarMenuLabel(UsniAdaptor::t('cms', 'Content')),
                                        'itemOptions' => array('class' => 'navblock-header'),
                                        'url'         => '#',
                                        'items'       => [
                                                            [
                                                                'label' => UsniAdaptor::t('cms', 'Pages'),
                                                                'url'   => ["/cms/page/manage"],
                                                                'visible'=> AuthManager::checkAccess($user, 'page.manage'),
                                                            ]
                                                          ]
                                    ]
                            ];
        }
    }
    
    /**
     * Get create items.
     * @param array $items
     * @return void
     */
    public static function getCreateItems(& $items)
    {
        $user  = UsniAdaptor::app()->user->getUserModel();
        $permissionModels = ['page'];
        $createItems = [];
        foreach($permissionModels as $permissionModel)
        {
            if(AuthManager::checkAccess($user, $permissionModel . '.create'))
            {
                $createItems[] = [
                                    'label'       => Page::getLabel(1),
                                    'url'         => "/cms/page/create"
                                 ];
            }
        }
        $items['create'] = $createItems;
    }
    
    /**
     * Get manage items.
     * @param array $items
     * @return void
     */
    public static function getManageItems(& $items)
    {
        $user  = UsniAdaptor::app()->user->getUserModel();
        $permissionModels = ['page'];
        $manageItems = [];
        foreach($permissionModels as $permissionModel)
        {
            if(AuthManager::checkAccess($user, $permissionModel . '.manage'))
            {
                $manageItems[] = [
                                    'label'       => AdminUtil::wrapSidebarMenuLabel(Page::getLabel(2)),
                                    'url'         => "/cms/page/manage"
                                 ];
            }
        }
        $items['manage'] = $manageItems;
    }
}