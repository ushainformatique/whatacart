<?php
use usni\library\utils\MenuUtil;
use usni\UsniAdaptor;

if(UsniAdaptor::app()->user->can('access.auth'))
{
    return [
                [
                    'label'       => MenuUtil::wrapLabel(UsniAdaptor::t('auth', 'Groups')),
                    'url'         => ['/auth/group/index'],
                    'itemOptions' => ['class' => 'navblock-header']
                ]
            ];
}
return [];

