<?php
use usni\library\utils\MenuUtil;
use usni\UsniAdaptor;
use usni\library\utils\ArrayUtil;

//Groups
$authItems  = require_once UsniAdaptor::app()->getModule('auth')->basePath . '/config/menu.php';
//Notifications
$notificationItems  = require_once UsniAdaptor::app()->getModule('notification')->basePath . '/config/menu.php';
//Service
$serviceItems  = require_once UsniAdaptor::app()->getModule('service')->basePath . '/config/menu.php';
//Users
$userItems  = require_once UsniAdaptor::app()->getModule('users')->basePath . '/config/menu.php';
//Data Categories
$dataCategoriesItems  = require_once UsniAdaptor::app()->getModule('dataCategories')->basePath . '/config/menu.php';
//Localization
$localItems  = require_once UsniAdaptor::app()->getModule('localization')->basePath . '/config/menu.php';
$sidebarItems       = ArrayUtil::merge($authItems, $notificationItems, $serviceItems, $userItems, $dataCategoriesItems, $localItems);
return [    
            'label'       => MenuUtil::getSidebarMenuIcon('cog') . MenuUtil::wrapLabel(UsniAdaptor::t('application', 'System')),
            'url'         => '#',
            'itemOptions' => ['class' => 'navblock-header'],
            'items'       => $sidebarItems
        ];

