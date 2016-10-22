<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace taxes\managers;

use usni\UsniAdaptor;
use usni\library\modules\auth\managers\AuthManager;
use usni\library\utils\AdminUtil;
/**
 * MenuManager class file.
 * @package taxes\managers
 */
class MenuManager extends \usni\library\managers\BaseMenuManager
{
    /**
     * Get controller path in route
     * @param string $key
     * @return string
     */
    public static function getControllerPathInRoute($key)
    {
        if($key == 'producttaxclass')
        {
            return 'product-tax-class';
        }
        if($key == 'taxrate')
        {
            return 'tax-rate';
        }
        if($key == 'taxrule')
        {
            return 'tax-rule';
        }
        if($key == 'zone')
        {
            return 'zone';
        }
        return null;
    }

    /**
     * Get sidebar items.
     * @param array $items
     */
    public static function getSidebarItems(& $items)
    {
        $user           = UsniAdaptor::app()->user->getUserModel();
        $subPermissionModels = static::getPermissionsArray();
        foreach($subPermissionModels as $subPermissionModel)
        {
            $controllerRoute       = static::getControllerPathInRoute($subPermissionModel);
            $subMenuSidebarItems[] = [
                                        'label' => self::getDisplayLabel($subPermissionModel, 2),
                                        'url'   => ["/localization/tax/$controllerRoute/manage"],
                                        'visible'=> AuthManager::checkAccess($user, $subPermissionModel . '.manage'),
                                      ];
        }
        if (AuthManager::checkAccess($user, 'access.tax'))
        {
            $items ['sidebar'] = [
                [
                    'label'       =>  UsniAdaptor::t('tax', 'Taxes'),
                    'itemOptions' => ['class' => 'navblock-header'],
                    'url'         => '#',
                    'items'       => $subMenuSidebarItems
                ]
            ];
        }
    }
    
    /**
     * @inheritdoc
     */
    public static function getCreateItems(&$items)
    {
        $createItems         = [];
        $user                = UsniAdaptor::app()->user->getUserModel();
        $subPermissionModels = static::getPermissionsArray();
        foreach($subPermissionModels as $subPermissionModel)
        {
            $controllerRoute       = static::getControllerPathInRoute($subPermissionModel);
            if(AuthManager::checkAccess($user, $subPermissionModel . '.create'))
            {
                $createItems[] = [
                                    'label'       => self::getDisplayLabel($subPermissionModel, 1),
                                    'url'         => "/localization/tax/$controllerRoute/create"
                                 ];
            }
        }
        $items['create'] = $createItems;
    }
    
    /**
     * @inheritdoc
     */
    public static function getManageItems(&$items)
    {
        $manageItems         = [];
        $user                = UsniAdaptor::app()->user->getUserModel();
        $subPermissionModels = static::getPermissionsArray();
        foreach($subPermissionModels as $subPermissionModel)
        {
            $controllerRoute       = static::getControllerPathInRoute($subPermissionModel);
            if(AuthManager::checkAccess($user, $subPermissionModel . '.manage'))
            {
                $labelText     = self::getDisplayLabel($subPermissionModel, 2);
                $manageItems[] = [
                                    'label'       => AdminUtil::wrapSidebarMenuLabel($labelText),
                                    'url'         => "/localization/tax/$controllerRoute/manage"
                                 ];
            }
        }
        $items['manage'] = $manageItems;
    }
    
    /**
     * Get label
     * @param string $key
     * @param int $n
     * @return string
     */
    public static function getDisplayLabel($key, $n)
    {
        if($key == 'producttaxclass')
        {
            return $n == 1 ? UsniAdaptor::t('tax', 'Product Tax Class') : UsniAdaptor::t('tax', 'Product Tax Classes');
        }
        if($key == 'taxrate')
        {
            return $n == 1 ? UsniAdaptor::t('tax', 'Tax Rate') : UsniAdaptor::t('tax', 'Tax Rates');
        }
        if($key == 'taxrule')
        {
            return $n == 1 ? UsniAdaptor::t('tax', 'Tax Rule') : UsniAdaptor::t('tax', 'Tax Rules');
        }
        if($key == 'zone')
        {
            return $n == 1 ? UsniAdaptor::t('tax', 'Zone') : UsniAdaptor::t('tax', 'Zones');
        }
        return null;
    }
    
    /**
     * Get permissions array
     * @return array
     */
    public static function getPermissionsArray()
    {
        return ['producttaxclass', 'taxrate', 'taxrule', 'zone'];
    }
    
    /**
     * @inheritdoc
     */
    public static function getModuleUniqueId()
    {
        return 'localization/tax';
    }
}