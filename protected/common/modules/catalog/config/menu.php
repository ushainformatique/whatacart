<?php
use usni\library\utils\MenuUtil;
use usni\UsniAdaptor;
use usni\library\utils\ArrayUtil;

//Categories
$catPath    = UsniAdaptor::getAlias('@productCategories');
$catItems   = require_once $catPath . '/config/menu.php';
//Products
$productPath    = UsniAdaptor::getAlias('@products');
$productItems   = require_once $productPath . '/config/menu.php';
//Manufacturer
$manPath        = UsniAdaptor::getAlias('@common/modules/manufacturer');
$manItems       = require_once $manPath . '/config/menu.php';
$sidebarItems   = ArrayUtil::merge($catItems, $productItems, $manItems);
if(UsniAdaptor::app()->user->can('access.catalog'))
{
    return [    
                'label'       => MenuUtil::getSidebarMenuIcon('shopping-cart') .
                                     MenuUtil::wrapLabel(UsniAdaptor::t('catalog', 'Catalog')),
                'url'         => '#',
                'itemOptions' => ['class' => 'navblock-header'],
                'items' => $sidebarItems
            ];
}
return [];

