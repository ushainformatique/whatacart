<?php
use usni\library\utils\MenuUtil;
use usni\UsniAdaptor;

if(UsniAdaptor::app()->user->can('access.catalog'))
{
    return [    
                [
                    'label'     => MenuUtil::wrapLabel(UsniAdaptor::t('productCategories', 'Product Category')),
                    'url'       => ['/catalog/productCategories/default/index'],
                    'visible'   => UsniAdaptor::app()->user->can('productcategory.manage'),
                ],
            ];
}
return [];
