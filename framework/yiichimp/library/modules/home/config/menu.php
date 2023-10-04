<?php
use usni\library\utils\MenuUtil;
use usni\UsniAdaptor;

return [
            'label' => MenuUtil::getSidebarMenuIcon('dashboard') . MenuUtil::wrapLabel(UsniAdaptor::t('application', 'Dashboard')),
            'url'   => ['/home/default/dashboard']
       ];
