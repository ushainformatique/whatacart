<?php
use usni\library\utils\MenuUtil;
use usni\UsniAdaptor;

$subItems = [
                [
                    'label'     => MenuUtil::wrapLabel(UsniAdaptor::t('language', 'Languages')),
                    'url'       => ['/language/default/index'],
                    'visible'   => UsniAdaptor::app()->user->can('access.language'),
                ],
                [
                    'label'     => MenuUtil::wrapLabel(UsniAdaptor::t('city', 'Cities')),
                    'url'       => ['/localization/city/default/index'],
                    'visible'   => UsniAdaptor::app()->user->can('access.localization'),
                ],
                [
                    'label'     => MenuUtil::wrapLabel(UsniAdaptor::t('country', 'Countries')),
                    'url'       => ['/localization/country/default/index'],
                    'visible'   => UsniAdaptor::app()->user->can('access.localization'),
                ],
                [
                    'label'     => MenuUtil::wrapLabel(UsniAdaptor::t('currency', 'Currencies')),
                    'url'       => ['/localization/currency/default/index'],
                    'visible'   => UsniAdaptor::app()->user->can('access.localization'),
                ],
                [
                    'label'     => MenuUtil::wrapLabel(UsniAdaptor::t('state', 'States')),
                    'url'       => ['/localization/state/default/index'],
                    'visible'   => UsniAdaptor::app()->user->can('access.localization'),
                ],
                [
                    'label'     => MenuUtil::wrapLabel(UsniAdaptor::t('lengthclass', 'Length Classes')),
                    'url'       => ['/localization/lengthclass/default/index'],
                    'visible'   => UsniAdaptor::app()->user->can('access.localization'),
                ],
                [
                    'label'     => MenuUtil::wrapLabel(UsniAdaptor::t('weightclass', 'Weight Classes')),
                    'url'       => ['/localization/weightclass/default/index'],
                    'visible'   => UsniAdaptor::app()->user->can('access.localization'),
                ],
                [
                    'label'     => MenuUtil::wrapLabel(UsniAdaptor::t('stockstatus', 'Stock Status')),
                    'url'       => ['/localization/stockstatus/default/index'],
                    'visible'   => UsniAdaptor::app()->user->can('access.localization'),
                ],
                [
                    'label'     => MenuUtil::wrapLabel(UsniAdaptor::t('orderstatus', 'Order Status')),
                    'url'       => ['/localization/orderstatus/default/index'],
                    'visible'   => UsniAdaptor::app()->user->can('access.localization'),
                ],
                [
                    'label'     => MenuUtil::wrapLabel(UsniAdaptor::t('tax', 'Taxes')),
                    'url'       => '#',
                    'visible'   => UsniAdaptor::app()->user->can('access.localization'),
                    'items'     => [
                                        [
                                            'label'     => MenuUtil::wrapLabel(UsniAdaptor::t('tax', 'Product Tax Classes')),
                                            'url'       => ['/localization/tax/product-tax-class/index']
                                        ],
                                        [
                                            'label'     => MenuUtil::wrapLabel(UsniAdaptor::t('tax', 'Tax Rules')),
                                            'url'       => ['/localization/tax/rule/index']
                                        ],
                                        [
                                            'label'     => MenuUtil::wrapLabel(UsniAdaptor::t('tax', 'Zones')),
                                            'url'       => ['/localization/tax/zone/index']
                                        ]
                                    ]
                ]
            ];
if(UsniAdaptor::app()->user->can('access.localization'))
{
    return [
                [
                    'label'       => MenuUtil::wrapLabel(UsniAdaptor::t('localization', 'Localization')),
                    'url'         => '#',
                    'itemOptions' => ['class' => 'navblock-header'],
                    'items' => $subItems
                ]
            ];
}
return [];

