<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace newsletter\managers;

use newsletter\models\Newsletter;
use usni\library\managers\BaseMenuManager;
use usni\library\modules\auth\managers\AuthManager;
use usni\UsniAdaptor;
use usni\library\utils\AdminUtil;
/**
 * MenuManager class file.
 * @package common\modules\newsletter\managers
 */
class MenuManager extends BaseMenuManager
{
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return Newsletter::className();
    }
    
    /**
     * @inheritdoc
     */
    public static function getIcon()
    {
        return null;
    }
    
    /**
     * @inheritdoc
     */
    public static function getModuleUniqueId()
    {
        return 'marketing/newsletter';
    }
    
    /**
     * @inheritdoc
     */
    public static function getSidebarItems(& $items)
    {
        $user  = UsniAdaptor::app()->user->getUserModel();
        $items = [];
        if(AuthManager::checkAccess($user, 'access.newsletter'))
        {
            $items ['sidebar'] =    [
                                            [
                                                'label'     => AdminUtil::wrapSidebarMenuLabel(UsniAdaptor::t('newsletter', 'Newsletter')),
                                                'url'       => ['/marketing/newsletter/default/manage'],
                                                'visible'   => AuthManager::checkAccess($user, 'newsletter.manage'),
                                            ]
                                    ];
        }
        return $items;
    }
}