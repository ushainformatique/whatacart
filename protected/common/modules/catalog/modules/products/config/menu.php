<?php
use usni\library\utils\MenuUtil;
use usni\UsniAdaptor;

if(UsniAdaptor::app()->user->can('access.catalog'))
{
    return [    
                [
                    'label'     => MenuUtil::wrapLabel(UsniAdaptor::t('products', 'Products')),
                    'url'       => ['/catalog/products/default/index'],
                    'visible'   => UsniAdaptor::app()->user->can('product.manage'),
                ],
                [
                    'label'     => MenuUtil::wrapLabel(UsniAdaptor::t('products', 'Attribute Groups')),
                    'url'       => ['/catalog/products/attribute-group/index'],
                    'visible'   => UsniAdaptor::app()->user->can('product.manage'),
                ],
                [
                    'label'     => MenuUtil::wrapLabel(UsniAdaptor::t('products', 'Attributes')),
                    'url'       => ['/catalog/products/attribute/index'],
                    'visible'   => UsniAdaptor::app()->user->can('product.manage'),
                ],
                [
                    'label'     => MenuUtil::wrapLabel(UsniAdaptor::t('products', 'Options')),
                    'url'       => ['/catalog/products/option/index'],
                    'visible'   => UsniAdaptor::app()->user->can('product.manage'),
                ],
                [
                    'label'     => MenuUtil::wrapLabel(UsniAdaptor::t('products', 'Downloads')),
                    'url'       => ['/catalog/products/download/index'],
                    'visible'   => UsniAdaptor::app()->user->can('product.manage'),
                ],
                [
                    'label'     => MenuUtil::wrapLabel(UsniAdaptor::t('products', 'Reviews')),
                    'url'       => ['/catalog/products/review/index'],
                    'visible'   => UsniAdaptor::app()->user->can('productreview.manage'),
                ]
            ];
}
return [];

