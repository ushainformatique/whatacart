<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\notification\controllers;

use usni\library\modules\notification\models\NotificationLayout;
use usni\library\web\actions\CreateAction;
use usni\library\web\actions\UpdateAction;
use usni\library\web\actions\IndexAction;
use usni\library\web\actions\ViewAction;
use usni\library\web\actions\DeleteAction;
use usni\library\web\actions\BulkDeleteAction;
use usni\library\dto\GridViewDTO;
use usni\library\dto\FormDTO;
use yii\filters\AccessControl;
use usni\library\modules\notification\business\layout\Manager;
/**
 * LayoutController class file
 * 
 * @package usni\library\modules\notification\controllers
 */
class LayoutController extends \usni\library\web\Controller
{
    /**
     * inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['notificationlayout.manage'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['notificationlayout.view'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['notificationlayout.create'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['notificationlayout.update'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete', 'bulk-delete'],
                        'roles' => ['notificationlayout.delete'],
                    ]
                ],
            ],
        ];
    }
    
    /**
     * inheritdoc
     */
    public function actions()
    {
        $managerConfig = ['class' => Manager::className()];
        return [
            'create' => ['class' => CreateAction::className(),
                         'modelClass' => NotificationLayout::className(),
                         'updateUrl'  => 'update',
                         'formDTOClass' => FormDTO::className(),
                         'viewFile' => '/layout/create',
                         'managerConfig' => $managerConfig
                        ],
            'update' => ['class' => UpdateAction::className(),
                         'modelClass' => NotificationLayout::className(),
                         'formDTOClass' => FormDTO::className(),
                         'viewFile' => '/layout/update',
                         'managerConfig' => $managerConfig
                        ],
            'index'  => ['class' => IndexAction::className(),
                         'modelClass' => NotificationLayout::className(),
                         'dtoClass' => GridViewDTO::className(),
                         'viewFile' => '/layout/index',
                         'managerConfig' => $managerConfig
                        ],
            'view'   => ['class' => ViewAction::className(),
                         'modelClass' => NotificationLayout::className(),
                         'viewFile' => '/layout/view',
                         'managerConfig' => $managerConfig
                        ],
            'delete'   => ['class' => DeleteAction::className(),
                         'modelClass' => NotificationLayout::className(),
                         'redirectUrl'=> 'index',
                         'permission' => 'notificationlayout.deleteother',
                         'managerConfig' => $managerConfig
                        ],
            'bulk-delete' => ['class' => BulkDeleteAction::className(),
                              'modelClass' => NotificationLayout::className(),
                              'managerConfig' => $managerConfig
                        ],
        ];
    }
}