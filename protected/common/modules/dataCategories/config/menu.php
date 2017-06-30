<?php
use usni\library\utils\MenuUtil;
use usni\UsniAdaptor;

if(UsniAdaptor::app()->user->can('access.dataCategories'))
{
    return [
                [
                    'label'       => MenuUtil::wrapLabel(UsniAdaptor::t('dataCategories', 'Data Categories')),
                    'url'         => ['/dataCategories/default/index'],
                    'itemOptions' => ['class' => 'navblock-header']
                ]
            ];
}
return [];

