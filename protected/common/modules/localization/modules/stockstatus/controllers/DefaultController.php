<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\stockstatus\controllers;

use common\modules\localization\modules\stockstatus\models\StockStatus;
use yii\filters\AccessControl;
use usni\library\web\actions\CreateAction;
use usni\library\web\actions\UpdateAction;
use usni\library\web\actions\IndexAction;
use usni\library\web\actions\ViewAction;
use usni\library\web\actions\DeleteAction;
use usni\library\web\actions\BulkDeleteAction;
/**
 * DefaultController class file
 * 
 * @package common\modules\localization\modules\stockstatus\controllers
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
                        'roles' => ['stockstatus.manage'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['stockstatus.view'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['stockstatus.create'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['stockstatus.update'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete', 'bulk-delete'],
                        'roles' => ['stockstatus.delete'],
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
                         'modelClass' => StockStatus::className(),
                         'updateUrl'  => 'update',
                         'viewFile' => '/create'
                        ],
            'update' => ['class' => UpdateAction::className(),
                         'modelClass' => StockStatus::className(),
                         'viewFile' => '/update'
                        ],
            'index'  => ['class' => IndexAction::className(),
                         'modelClass' => StockStatus::className(),
                         'viewFile' => '/index'
                        ],
            'view'   => ['class' => ViewAction::className(),
                         'modelClass' => StockStatus::className(),
                         'viewFile' => '/view'
                        ],
            'delete'   => ['class' => DeleteAction::className(),
                         'modelClass' => StockStatus::className(),
                         'redirectUrl'=> 'index',
                         'permission' => 'stockstatus.deleteother'
                        ],
            'bulk-delete' => ['class' => BulkDeleteAction::className(),
                              'modelClass' => StockStatus::className()
                        ],
        ];
    }
}