<?php
use usni\library\utils\MenuUtil;
use usni\UsniAdaptor;

if(UsniAdaptor::app()->user->can('access.service'))
{
    return [
                [
                    'label'       => MenuUtil::wrapLabel(UsniAdaptor::t('service', 'Services')),
                    'url'         => ['/service/default/index'],
                    'itemOptions' => ['class' => 'navblock-header']
                ]
            ];
}
return [];

