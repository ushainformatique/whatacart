<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\controllers;

use products\models\ProductAttributeGroup;
use yii\filters\AccessControl;
use usni\library\web\actions\CreateAction;
use usni\library\web\actions\UpdateAction;
use products\business\AttributeGroupManager;
use usni\library\web\actions\IndexAction;
use usni\library\web\actions\DeleteAction;
use usni\library\web\actions\BulkDeleteAction;
use usni\library\web\actions\ViewAction;
/**
 * AttributeGroupController class file.
 * 
 * @package products\controllers
 */
class AttributeGroupController extends \usni\library\web\Controller
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
                        'roles' => ['product.manage'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['product.view'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['product.create'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['product.update'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete', 'bulk-delete'],
                        'roles' => ['product.delete'],
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
        $managerConfig = ['class'    => AttributeGroupManager::className()];
        return [
            'create' => ['class' => CreateAction::className(),
                         'modelClass' => ProductAttributeGroup::className(),
                         'updateUrl'  => 'update',
                         'managerConfig' => $managerConfig,
                         'viewFile' => '/attributegroup/create'
                        ],
            'update' => ['class' => UpdateAction::className(),
                         'modelClass' => ProductAttributeGroup::className(),
                         'managerConfig' => $managerConfig,
                         'viewFile' => '/attributegroup/update',
                        ],
            'index'  => ['class' => IndexAction::className(),
                         'modelClass' => ProductAttributeGroup::className(),
                         'managerConfig' => $managerConfig,
                         'viewFile' => '/attributegroup/index'
                        ],
            'view'   => ['class' => ViewAction::className(),
                         'modelClass' => ProductAttributeGroup::className(),
                         'managerConfig' => $managerConfig,
                         'viewFile' => '/attributegroup/view'
                        ],
            'delete'   => ['class' => DeleteAction::className(),
                         'modelClass' => ProductAttributeGroup::className(),
                         'redirectUrl'=> 'index',
                         'permission' => 'product.deleteother'
                        ],
            'bulk-delete' => ['class' => BulkDeleteAction::className(),
                              'modelClass' => ProductAttributeGroup::className(),
                              'managerConfig' => $managerConfig,
                        ],
        ];
    }
}
