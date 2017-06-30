<?php
use usni\library\utils\MenuUtil;
use usni\UsniAdaptor;

if(UsniAdaptor::app()->user->can('access.marketing'))
{
    return [    
                'label'       => MenuUtil::getSidebarMenuIcon('share') .
                                     MenuUtil::wrapLabel(UsniAdaptor::t('marketing', 'Marketing')),
                'url'         => '#',
                'itemOptions' => ['class' => 'navblock-header'],
                'items'       => [
                                    [
                                        'label'     => UsniAdaptor::t('marketing', 'Mails'),
                                        'url'       => ['/marketing/send-mail/create'],
                                        'visible'   => UsniAdaptor::app()->user->can('marketing.mail'),
                                    ],
                                    [
                                        'label'     => UsniAdaptor::t('newsletter', 'Newsletters'),
                                        'url'       => ['/marketing/newsletter/default/index'],
                                        'visible'   => UsniAdaptor::app()->user->can('newsletter.manage'),
                                    ]
                                  ]
            ];
}
return [];

