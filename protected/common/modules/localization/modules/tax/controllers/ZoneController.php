<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\controllers;

use taxes\models\Zone;
use yii\filters\AccessControl;
use taxes\business\ZoneManager;
use usni\library\web\actions\CreateAction;
use usni\library\web\actions\UpdateAction;
use usni\library\web\actions\IndexAction;
use usni\library\web\actions\ViewAction;
use usni\library\web\actions\DeleteAction;
use usni\library\web\actions\BulkDeleteAction;
use taxes\dto\ZoneFormDTO;
use taxes\dto\ZoneGridViewDTO;
/**
 * ZoneController class file.
 * 
 * @package taxes\controllers
 */
class ZoneController extends \usni\library\web\Controller
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
                        'roles' => ['zone.manage'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['zone.view'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['zone.create'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['zone.update'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete', 'bulk-delete'],
                        'roles' => ['zone.delete'],
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
        $managerConfig = [
                            'class'    => ZoneManager::className()
                         ];
        return [
            'create' => ['class' => CreateAction::className(),
                         'modelClass' => Zone::className(),
                         'updateUrl'  => 'update',
                         'managerConfig' => $managerConfig,
                         'viewFile' => '/zone/create',
                         'formDTOClass' => ZoneFormDTO::className()
                        ],
            'update' => ['class' => UpdateAction::className(),
                         'modelClass' => Zone::className(),
                         'managerConfig' => $managerConfig,
                         'viewFile' => '/zone/update',
                         'formDTOClass' => ZoneFormDTO::className()
                        ],
            'index'  => ['class' => IndexAction::className(),
                         'modelClass' => Zone::className(),
                         'managerConfig' => $managerConfig,
                         'viewFile' => '/zone/index',
                         'dtoClass' => ZoneGridViewDTO::className()
                        ],
            'view'   => ['class' => ViewAction::className(),
                         'modelClass' => Zone::className(),
                         'managerConfig' => $managerConfig,
                         'viewFile' => '/zone/view'
                        ],
            'delete'   => ['class' => DeleteAction::className(),
                           'modelClass' => Zone::className(),
                           'redirectUrl'=> 'index',
                           'permission' => 'zone.deleteother'
                        ],
            'bulk-delete' => ['class' => BulkDeleteAction::className(),
                              'modelClass' => Zone::className()
                        ],
        ];
    }
}