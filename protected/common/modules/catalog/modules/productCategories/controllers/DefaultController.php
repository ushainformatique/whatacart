<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace productCategories\controllers;

use productCategories\models\ProductCategory;
use yii\filters\AccessControl;
use usni\library\web\actions\CreateAction;
use usni\library\web\actions\UpdateAction;
use productCategories\dto\FormDTO;
use productCategories\business\Manager;
use usni\library\web\actions\IndexAction;
use productCategories\web\actions\DeleteAction;
use usni\library\web\actions\BulkEditAction;
use usni\library\web\actions\BulkDeleteAction;
use usni\library\web\actions\ViewAction;
/**
 * DefaultController class file
 *
 * @package productCategories\controllers
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
                        'roles' => ['productcategory.manage'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['productcategory.view'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['productcategory.create'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update', 'bulk-edit'],
                        'roles' => ['productcategory.update'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete', 'bulk-delete'],
                        'roles' => ['productcategory.delete'],
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
        $managerConfig = ['class'    => Manager::className()];
        return [
            'create' => ['class' => CreateAction::className(),
                         'modelClass' => ProductCategory::className(),
                         'updateUrl'  => 'update',
                         'managerConfig' => $managerConfig,
                         'formDTOClass' => FormDTO::className(),
                         'viewFile' => '/create'
                        ],
            'update' => ['class' => UpdateAction::className(),
                         'modelClass' => ProductCategory::className(),
                         'managerConfig' => $managerConfig,
                         'formDTOClass' => FormDTO::className(),
                         'viewFile' => '/update'
                        ],
            'index'  => ['class' => IndexAction::className(),
                         'modelClass' => ProductCategory::className(),
                         'managerConfig' => $managerConfig,
                         'viewFile' => '/index'
                        ],
            'view'   => ['class' => ViewAction::className(),
                         'modelClass' => ProductCategory::className(),
                         'managerConfig' => $managerConfig,
                         'viewFile' => '/view'
                        ],
            'delete'   => ['class' => DeleteAction::className(),
                            'modelClass' => ProductCategory::className(),
                            'redirectUrl'=> 'index',
                            'permission' => 'productcategory.deleteother'
                          ],
            'bulk-edit' => ['class' => BulkEditAction::className(),
                            'modelClass' => ProductCategory::className()
                        ],
            'bulk-delete' => ['class' => BulkDeleteAction::className(),
                              'modelClass' => ProductCategory::className()
                        ]
        ];
    }
}