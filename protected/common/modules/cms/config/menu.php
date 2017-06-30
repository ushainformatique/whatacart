<?php
use usni\library\utils\MenuUtil;
use usni\UsniAdaptor;

if(UsniAdaptor::app()->user->can('access.cms'))
{
    return [    
                'label'       => MenuUtil::getSidebarMenuIcon('pencil') .
                                     MenuUtil::wrapLabel(UsniAdaptor::t('cms', 'Content')),
                'url'         => '#',
                'itemOptions' => ['class' => 'navblock-header'],
                'items'       => [
                                    [
                                        'label' => UsniAdaptor::t('cms', 'Pages'),
                                        'url'   => ["/cms/page/index"],
                                        'visible'=> UsniAdaptor::app()->user->can('page.manage'),
                                    ]
                                  ]
            ];
}
return [];

