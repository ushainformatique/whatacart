<?php
use usni\library\utils\MenuUtil;
use usni\UsniAdaptor;

if(UsniAdaptor::app()->user->can('access.users'))
{
    return [
                [
                    'label'       => MenuUtil::wrapLabel(UsniAdaptor::t('users', 'Users')),
                    'url'         => ['/users/default/index'],
                    'itemOptions' => ['class' => 'navblock-header']
                ]
            ];
}
return [];

