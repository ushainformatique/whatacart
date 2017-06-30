<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\controllers;

use taxes\models\ProductTaxClass;
use yii\filters\AccessControl;
use usni\library\web\actions\CreateAction;
use usni\library\web\actions\UpdateAction;
use usni\library\web\actions\IndexAction;
use usni\library\web\actions\ViewAction;
use usni\library\web\actions\DeleteAction;
use usni\library\web\actions\BulkDeleteAction;
use taxes\business\ProductTaxClassManager;
/**
 * ProductTaxClassController class file.
 * 
 * @package taxes\controllers
 */
class ProductTaxClassController extends \usni\library\web\Controller
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
                        'roles' => ['producttaxclass.manage'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['producttaxclass.view'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['producttaxclass.create'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['producttaxclass.update'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete', 'bulk-delete'],
                        'roles' => ['producttaxclass.delete'],
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
        $managerConfig = [
                            'class'    => ProductTaxClassManager::className()
                         ];
        return [
            'create' => ['class' => CreateAction::className(),
                         'modelClass' => ProductTaxClass::className(),
                         'updateUrl'  => 'update',
                         'managerConfig' => $managerConfig,
                         'viewFile' => '/producttaxclass/create',
                        ],
            'update' => ['class' => UpdateAction::className(),
                         'modelClass' => ProductTaxClass::className(),
                         'managerConfig' => $managerConfig,
                         'viewFile' => '/producttaxclass/update',
                        ],
            'index'  => ['class' => IndexAction::className(),
                         'modelClass' => ProductTaxClass::className(),
                         'managerConfig' => $managerConfig,
                         'viewFile' => '/producttaxclass/index',
                        ],
            'view'   => ['class' => ViewAction::className(),
                         'modelClass' => ProductTaxClass::className(),
                         'managerConfig' => $managerConfig,
                         'viewFile' => '/producttaxclass/view'
                        ],
            'delete'   => ['class' => DeleteAction::className(),
                         'modelClass' => ProductTaxClass::className(),
                         'redirectUrl'=> 'index',
                         'permission' => 'producttaxclass.deleteother'
                        ],
            'bulk-delete' => ['class' => BulkDeleteAction::className(),
                              'modelClass' => ProductTaxClass::className()
                        ],
        ];
    }
}