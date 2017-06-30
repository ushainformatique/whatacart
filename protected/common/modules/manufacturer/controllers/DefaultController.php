<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\manufacturer\controllers;

use common\modules\manufacturer\models\Manufacturer;
use usni\library\web\actions\CreateAction;
use usni\library\web\actions\UpdateAction;
use usni\library\web\actions\IndexAction;
use usni\library\web\actions\ViewAction;
use usni\library\web\actions\DeleteAction;
use usni\library\web\actions\BulkEditAction;
use usni\library\web\actions\BulkDeleteAction;
use yii\filters\AccessControl;
use usni\library\web\actions\DeleteImageAction;
/**
 * DefaultController class file
 * 
 * @package common\modules\manufacturer\controllers
 */
class DefaultController extends \usni\library\web\Controller
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
                        'roles' => ['manufacturer.manage'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['manufacturer.view'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['manufacturer.create'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update', 'bulk-edit', 'delete-image'],
                        'roles' => ['manufacturer.update'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete', 'bulk-delete'],
                        'roles' => ['manufacturer.delete'],
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
                         'modelClass' => Manufacturer::className(),
                         'updateUrl'  => 'update',
                         'viewFile' => '/create'
                        ],
            'update' => ['class' => UpdateAction::className(),
                         'modelClass' => Manufacturer::className(),
                         'viewFile' => '/update'
                        ],
            'index'  => ['class' => IndexAction::className(),
                         'modelClass' => Manufacturer::className(),
                         'viewFile' => '/index'],
            'view'   => ['class' => ViewAction::className(),
                         'modelClass' => Manufacturer::className(),
                         'viewFile' => '/view'
                        ],
            'delete'   => ['class' => DeleteAction::className(),
                         'modelClass' => Manufacturer::className(),
                         'redirectUrl'=> 'index',
                         'permission' => 'manufacturer.deleteother'
                        ],
            'bulk-edit' => ['class' => BulkEditAction::className(),
                         'modelClass' => Manufacturer::className()
                        ],
            'bulk-delete' => ['class' => BulkDeleteAction::className(),
                              'modelClass' => Manufacturer::className()
                        ],
            'delete-image' => [
                            'class' => DeleteImageAction::className(),
                            'modelClass' => Manufacturer::className(),
                            'attribute' => 'image'
                        ]
        ];
    }
}