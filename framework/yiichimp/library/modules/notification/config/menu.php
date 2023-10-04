<?php
use usni\library\utils\MenuUtil;
use usni\UsniAdaptor;

if(UsniAdaptor::app()->user->can('access.notification'))
{
    return [    
                [
                    'label'       => MenuUtil::wrapLabel(UsniAdaptor::t('notification', 'Notifications')),
                    'url'         => '#',
                    'itemOptions' => ['class' => 'navblock-header'],
                    'items'       => array(
                                            array(
                                                    'label' => UsniAdaptor::t('notification', 'Templates'),
                                                    'url'   => array('/notification/template/index'),
                                                    'visible'=> UsniAdaptor::app()->user->can('notificationtemplate.manage'),
                                                 ),
                                            array(
                                                    'label' => UsniAdaptor::t('notification', 'Layouts'),
                                                    'url'   => array('/notification/layout/index'),
                                                    'visible'=> UsniAdaptor::app()->user->can('notificationlayout.manage'),
                                                 ),
                                            array(
                                                    'label' => UsniAdaptor::t('notification', 'List All'),
                                                    'url'   => array('/notification/default/index'),
                                                    'visible'=> UsniAdaptor::app()->user->can('notification.manage'),
                                                 )
                                            )
                ]
            ];
}
return [];

