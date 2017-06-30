<?php
use usni\library\utils\MenuUtil;
use usni\UsniAdaptor;

if(UsniAdaptor::app()->user->can('access.extension'))
{
    return [    
                'label'       => MenuUtil::getSidebarMenuIcon('puzzle-piece') .
                                     MenuUtil::wrapLabel(UsniAdaptor::t('extension', 'Extensions')),
                'url'         => '#',
                'itemOptions' => ['class' => 'navblock-header'],
                'items'       => [
                                    [
                                        'label'       => UsniAdaptor::t('extension', 'Enhancements'),
                                        'url'         => ['/enhancement/default/index'],
                                    ],
                                    [
                                        'label'       => UsniAdaptor::t('extension', 'Payment Methods'),
                                        'url'         => ['/payment/default/index'],
                                    ],
                                    [
                                        'label'       => UsniAdaptor::t('extension', 'Shipping Methods'),
                                        'url'         => ['/shipping/default/index'],
                                    ],
                                    [
                                        'label'       => UsniAdaptor::t('extension', 'Modules'),
                                        'url'         => ['/extension/module/index'],
                                    ],
                                    [
                                        'label'       => UsniAdaptor::t('extension', 'Modifications'),
                                        'url'         => ['/extension/modification/index'],
                                    ]
                                  ]
            ];
}
return [];

