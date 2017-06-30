<?php
return [
            'users' => ['controllerNamespace' => 'frontend\controllers\users'],
            'site' => [
                        'components' => [
                                            'viewHelper' => [
                                                                'class' => 'frontend\modules\site\components\ViewHelper'
                                                            ]
                                        ]
                      ],
            'cart' => ['components'   => [
                        'viewHelper' => [
                                            'class' => 'cart\components\front\ViewHelper'
                                        ]
                        ]
                      ],
            'order'  => [
                    'components'   => [
                        'viewHelper' => [
                            'class' => 'common\modules\order\components\front\ViewHelper',
                        ]
                    ]
                   ],
            'cms'  => [
                    'components'   => [
                        'viewHelper' => [
                            'class' => 'common\modules\cms\components\ViewHelper'
                        ]
                    ]                   
              ],
       ];
