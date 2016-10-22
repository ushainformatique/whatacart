<?php
return [
    'auth'      => [
                        'dataManagerPath' => ['common\managers'],
                        'controllerMap' => ['group' => 'backend\controllers\auth\GroupController']
                   ],
    'install'   => ['controllerMap' => ['default' => 'backend\controllers\install\ExtendedDefaultController']],
    'users'     => [
                        'controllerMap' => ['default' => 'backend\controllers\users\DefaultController'],
                        'components'   => [
                        'viewHelper' => [
                            'class' => 'usni\library\modules\users\components\ViewHelper',
                        ]
                    ]
                   ],
    'order'  => [
                    'components'   => [
                        'viewHelper' => [
                            'class' => 'common\modules\order\components\ViewHelper',
                        ]
                    ]
                   ],
    'settings'  => [
                    'components'   => [
                        'viewHelper' => [
                            'class' => 'usni\library\modules\settings\components\ViewHelper',
                            'menuSettingsView' => 'backend\views\settings\MenuSettingsView'
                        ]
                    ]
                   ],
    'language'  => [
                    'components'   => [
                        'viewHelper' => [
                            'class' => 'common\modules\localization\modules\language\components\ViewHelper'
                        ]
                    ]
                   ],
    'stores'  => [
                    'components'   => [
                        'viewHelper' => [
                            'class' => 'common\modules\stores\components\ViewHelper'
                        ]
                    ]
                   ],
    'cart' => ['components'   => [
                        'viewHelper' => [
                                            'class' => 'cart\components\ViewHelper'
                                        ]
                        ]
              ],
];
