<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\managers;

use usni\UsniAdaptor;
use usni\library\modules\auth\managers\AuthManager;
use products\models\Product;
use usni\library\utils\AdminUtil;
/**
 * MenuManager class file.
 * 
 * @package common\modules\catalog\components
 */
class MenuManager extends \usni\library\managers\BaseMenuManager
{
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return Product::className();
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
    public static function getSidebarItems(& $items)
    {
        $user  = UsniAdaptor::app()->user->getUserModel();
        $items ['sidebar'] = [];
        $items = [];
        if(AuthManager::checkAccess($user, 'access.catalog'))
        {
            $items ['sidebar'] =    [
                                            [
                                                'label'     => AdminUtil::wrapSidebarMenuLabel(UsniAdaptor::t('products', 'Products')),
                                                'url'       => ['/catalog/products/default/manage'],
                                                'visible'   => AuthManager::checkAccess($user, 'product.manage'),
                                            ],
                                            [
                                                'label'     => AdminUtil::wrapSidebarMenuLabel(UsniAdaptor::t('products', 'Attribute Groups')),
                                                'url'       => ['/catalog/products/attribute-group/manage'],
                                                'visible'   => AuthManager::checkAccess($user, 'product.manage'),
                                            ],
                                            [
                                                'label'     => AdminUtil::wrapSidebarMenuLabel(UsniAdaptor::t('products', 'Attributes')),
                                                'url'       => ['/catalog/products/attribute/manage'],
                                                'visible'   => AuthManager::checkAccess($user, 'product.manage'),
                                            ],
                                            [
                                                'label'     => AdminUtil::wrapSidebarMenuLabel(UsniAdaptor::t('products', 'Options')),
                                                'url'       => ['/catalog/products/option/manage'],
                                                'visible'   => AuthManager::checkAccess($user, 'product.manage'),
                                            ],
                                            [
                                                'label'     => AdminUtil::wrapSidebarMenuLabel(UsniAdaptor::t('products', 'Reviews')),
                                                'url'       => ['/catalog/products/review/manage'],
                                                'visible'   => AuthManager::checkAccess($user, 'product.manage'),
                                            ]
                                    ];
        }
        return $items;
    }
    
    /**
     * @inheritdoc
     */
    public static function getModuleUniqueId()
    {
        return 'catalog/products';
    }
}