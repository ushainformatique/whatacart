<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\notification\controllers;

use usni\library\modules\notification\models\NotificationTemplate;
use usni\library\web\actions\CreateAction;
use usni\library\web\actions\UpdateAction;
use usni\library\web\actions\IndexAction;
use usni\library\web\actions\ViewAction;
use usni\library\web\actions\DeleteAction;
use usni\library\web\actions\BulkEditAction;
use usni\library\web\actions\BulkDeleteAction;
use usni\library\modules\notification\dto\TemplateGridViewDTO;
use usni\library\modules\notification\dto\TemplateFormDTO;
use yii\filters\AccessControl;
use usni\library\modules\notification\business\template\Manager;
/**
 * TemplateController class file
 * 
 * @package usni\library\modules\notification\controllers
 */
class TemplateController extends \usni\library\web\Controller
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
                        'roles' => ['notificationtemplate.manage'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view', 'grid-preview', 'preview'],
                        'roles' => ['notificationtemplate.view'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['notificationtemplate.create']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update', 'bulk-edit'],
                        'roles' => ['notificationtemplate.update'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete', 'bulk-delete'],
                        'roles' => ['notificationtemplate.delete'],
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
                         'modelClass' => NotificationTemplate::className(),
                         'updateUrl'  => 'update',
                         'formDTOClass' => TemplateFormDTO::className(),
                         'viewFile' => '/template/create',
                         'managerConfig' => $managerConfig
                        ],
            'update' => ['class' => UpdateAction::className(),
                         'modelClass' => NotificationTemplate::className(),
                         'formDTOClass' => TemplateFormDTO::className(),
                         'viewFile' => '/template/update',
                         'managerConfig' => $managerConfig
                        ],
            'index'  => ['class' => IndexAction::className(),
                         'modelClass' => NotificationTemplate::className(),
                         'dtoClass' => TemplateGridViewDTO::className(),
                         'viewFile' => '/template/index',
                         'managerConfig' => $managerConfig
                        ],
            'view'   => ['class' => ViewAction::className(),
                         'modelClass' => NotificationTemplate::className(),
                         'viewFile' => '/template/view',
                         'managerConfig' => $managerConfig
                        ],
            'delete'   => ['class' => DeleteAction::className(),
                         'modelClass' => NotificationTemplate::className(),
                         'redirectUrl'=> 'index',
                         'permission' => 'notificationtemplate.deleteother',
                         'managerConfig' => $managerConfig
                        ],
            'bulk-edit' => ['class' => BulkEditAction::className(),
                         'modelClass' => NotificationTemplate::className(),
                         'managerConfig' => $managerConfig
                        ],
            'bulk-delete' => ['class' => BulkDeleteAction::className(),
                              'modelClass' => NotificationTemplate::className(),
                              'managerConfig' => $managerConfig
                        ],
        ];
    }
    
    /**
     * Action Preview to render preview of notification template from grid view.
     * @param integer $id
     * @return void
     */
    public function actionGridPreview($id)
    {
        return Manager::getInstance()->processGridPreview($id);
    }
    
    /**
     * Action Preview to render preview of notification template from edit view.
     * @return void
     */
    public function actionPreview()
    {
        return Manager::getInstance()->processPreview($_POST['NotificationTemplate']);
    }
}