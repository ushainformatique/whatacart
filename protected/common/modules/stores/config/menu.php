<?php
use usni\library\utils\MenuUtil;
use usni\UsniAdaptor;

if(UsniAdaptor::app()->user->can('access.stores'))
{
    return [    
                'label'       => MenuUtil::getSidebarMenuIcon('globe') .
                                     MenuUtil::wrapLabel(UsniAdaptor::t('stores', 'Stores')),
                'url'         => ['/stores/default/index'],
                'itemOptions' => ['class' => 'navblock-header']
            ];
}
return [];

