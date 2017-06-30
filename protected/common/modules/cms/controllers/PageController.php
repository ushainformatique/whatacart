<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\cms\controllers;

use yii\filters\AccessControl;
use usni\library\web\actions\IndexAction;
use common\modules\cms\models\Page;
use usni\library\web\actions\CreateAction;
use common\modules\cms\dto\FormDTO;
use usni\library\web\actions\UpdateAction;
use usni\library\web\actions\BulkEditAction;
use common\modules\cms\dto\GridViewDTO;
use usni\library\web\actions\DeleteAction;
use usni\library\web\actions\BulkDeleteAction;
use usni\library\web\actions\ViewAction;
/**
 * PageController class file.
 * 
 * @package common\modules\cms\controllers
 */
class PageController extends \usni\library\web\Controller
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
                        'roles' => ['page.manage'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['page.view'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['page.create'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update', 'bulk-edit'],
                        'roles' => ['page.update'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete', 'bulk-delete'],
                        'roles' => ['page.delete'],
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
        return [
            'create' => ['class' => CreateAction::className(),
                         'modelClass' => Page::className(),
                         'updateUrl'  => 'update',
                         'formDTOClass' => FormDTO::className(),
                         'viewFile' => '/create'
                        ],
            'update' => ['class' => UpdateAction::className(),
                         'modelClass' => Page::className(),
                         'formDTOClass' => FormDTO::className(),
                         'viewFile' => '/update'
                        ],
            'index'  => ['class' => IndexAction::className(),
                         'modelClass' => Page::className(),
                         'dtoClass' => GridViewDTO::className(),
                         'viewFile' => '/index'
                        ],
            'view'   => ['class' => ViewAction::className(),
                         'modelClass' => Page::className(),
                         'viewFile' => '/view'
                        ],
            'delete'   => ['class' => DeleteAction::className(),
                         'modelClass' => Page::className(),
                         'redirectUrl'=> 'index',
                         'permission' => 'page.deleteother'
                        ],
            'bulk-edit' => ['class' => BulkEditAction::className(),
                            'modelClass' => Page::className()
                        ],
            'bulk-delete' => ['class' => BulkDeleteAction::className(),
                              'modelClass' => Page::className()
                        ],
        ];
    }
}