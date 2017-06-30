<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\currency\controllers;

use common\modules\localization\modules\currency\models\Currency;
use yii\filters\AccessControl;
use usni\library\web\actions\CreateAction;
use usni\library\web\actions\UpdateAction;
use usni\library\web\actions\IndexAction;
use usni\library\web\actions\BulkEditAction;
use usni\library\web\actions\BulkDeleteAction;
use usni\library\web\actions\DeleteAction;
use usni\library\web\actions\ViewAction;
/**
 * DefaultController class file
 * 
 * @package common\modules\localization\modules\currency\controllers
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
                        'roles' => ['currency.manage'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['currency.view'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['currency.create'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update', 'bulk-edit'],
                        'roles' => ['currency.update'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete', 'bulk-delete'],
                        'roles' => ['currency.delete'],
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
                         'modelClass' => Currency::className(),
                         'updateUrl'  => 'update',
                         'viewFile' => '/create'
                        ],
            'update' => ['class' => UpdateAction::className(),
                         'modelClass' => Currency::className(),
                         'viewFile' => '/update'
                        ],
            'index'  => ['class' => IndexAction::className(),
                         'modelClass' => Currency::className(),
                         'viewFile' => '/index'
                        ],
            'view'   => ['class' => ViewAction::className(),
                         'modelClass' => Currency::className(),
                         'viewFile' => '/view'
                        ],
            'delete'   => ['class' => DeleteAction::className(),
                           'modelClass' => Currency::className(),
                           'redirectUrl'=> 'index',
                           'permission' => 'currency.deleteother'
                        ],
            'bulk-edit' => ['class' => BulkEditAction::className(),
                            'modelClass' => Currency::className()
                        ],
            'bulk-delete' => ['class' => BulkDeleteAction::className(),
                              'modelClass' => Currency::className()
                        ],
        ];
    }
}