<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\controllers;

use yii\filters\AccessControl;
use usni\library\web\actions\CreateAction;
use customer\business\GroupManager;
use usni\library\modules\auth\dto\FormDTO;
use usni\library\web\actions\UpdateAction;
use usni\library\web\actions\IndexAction;
use usni\library\modules\auth\dto\GridViewDTO;
use customer\models\CustomerGroupSearch;
use usni\library\web\actions\BulkEditAction;
use usni\library\web\actions\BulkDeleteAction;
use usni\library\web\actions\DeleteAction;
use usni\library\web\actions\ViewAction;
use customer\models\CustomerGroup;
/**
 * GroupController for customer.
 *
 * @package customer\controllers
 */
class GroupController extends \usni\library\web\Controller
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
                        'roles' => ['group.manage'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['group.view'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['group.create'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update', 'bulk-edit', 'delete-image'],
                        'roles' => ['group.update'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete', 'bulk-delete'],
                        'roles' => ['group.delete'],
                    ],
                ],
            ],
        ];
    }
    
    /**
     * inheritdoc
     */
    public function actions()
    {
        $managerConfig = ['class' => GroupManager::className()];
        return [
            'create' => ['class' => CreateAction::className(),
                         'modelClass' => CustomerGroup::className(),
                         'updateUrl'  => 'update',
                         'formDTOClass' => FormDTO::className(),
                         'managerConfig' => $managerConfig,
                         'viewFile' => '/groups/create'
                        ],
            'update' => ['class' => UpdateAction::className(),
                         'modelClass' => CustomerGroup::className(),
                         'formDTOClass' => FormDTO::className(),
                         'managerConfig' => $managerConfig,
                         'viewFile' => '/groups/update'
                        ],
            'index'  => ['class' => IndexAction::className(),
                         'modelClass' => CustomerGroup::className(),
                         'dtoClass' => GridViewDTO::className(),
                         'managerConfig' => $managerConfig,
                         'viewFile' => '/groups/index',
                         'searchConfig' => ['class' => CustomerGroupSearch::className()]
                        ], 
            'view'   => ['class' => ViewAction::className(),
                         'modelClass' => CustomerGroup::className(),
                         'viewFile' => '/groups/view',
                         'managerConfig' => $managerConfig
                        ],
            'delete'   => ['class' => DeleteAction::className(),
                           'modelClass' => CustomerGroup::className(),
                           'redirectUrl'=> 'index',
                           'managerConfig' => $managerConfig,
                           'permission' => 'group.deleteother'
                        ],
            'bulk-edit' => ['class' => BulkEditAction::className(),
                            'modelClass' => CustomerGroup::className(),
                            'managerConfig' => $managerConfig
                        ],
            'bulk-delete' => ['class' => BulkDeleteAction::className(),
                              'modelClass' => CustomerGroup::className(),
                              'managerConfig' => $managerConfig
                        ],
        ];
    }
}