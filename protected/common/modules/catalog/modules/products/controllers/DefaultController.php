<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\controllers;

use products\models\Product;
use usni\UsniAdaptor;
use yii\web\Response;
use yii\filters\AccessControl;
use usni\library\web\actions\CreateAction;
use usni\library\web\actions\UpdateAction;
use usni\library\web\actions\IndexAction;
use usni\library\web\actions\BulkDeleteAction;
use usni\library\web\actions\ViewAction;
use products\dto\FormDTO;
use products\business\Manager;
use usni\library\dto\GridViewDTO;
use usni\library\web\actions\BulkEditAction;
use products\web\actions\DeleteAction;
/**
 * Default controller for products module.
 * 
 * @package products\controllers
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
                        'actions' => ['update', 'bulk-edit'],
                        'roles' => ['product.update'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete', 'bulk-delete'],
                        'roles' => ['product.delete'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['latest']
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
        return [
            'create' => ['class' => CreateAction::className(),
                         'modelClass' => Product::className(),
                         'updateUrl'  => 'update',
                         'formDTOClass' => FormDTO::className(),
                         'viewFile' => '/create'
                        ],
            'update' => ['class' => UpdateAction::className(),
                         'modelClass' => Product::className(),
                         'formDTOClass' => FormDTO::className(),
                         'viewFile' => '/update'
                        ],
            'index'  => ['class' => IndexAction::className(),
                         'modelClass' => Product::className(),
                         'viewFile' => '/index'
                        ],
            'view'   => ['class' => ViewAction::className(),
                         'modelClass' => Product::className(),
                         'viewFile' => '/view'
                        ],
            'delete'   => ['class' => DeleteAction::className(),
                           'modelClass' => Product::className(),
                           'redirectUrl'=> 'index',
                           'permission' => 'product.deleteother'
                        ],
            'bulk-delete' => ['class' => BulkDeleteAction::className(),
                              'modelClass' => Product::className()
                        ],
            'bulk-edit' => ['class' => BulkEditAction::className(),
                            'modelClass' => Product::className()
                        ],
        ];
    }
    
    /**
     * List the tag names.
     * @param string $query
     * @return json
     */
    public function actionTags($query)
    {
        $manager = new Manager();
        $items = $manager->getTagItems($query);
        // We know we can use ContentNegotiator filter
        // this way is easier to show you here :)
        UsniAdaptor::app()->response->format = Response::FORMAT_JSON;
        return $items;
    }
    
    /**
     * Get the latest products
     * @return string
     */
    public function actionLatest()
    {
        $manager = Manager::getInstance();
        $gridViewDTO = new GridViewDTO();
        $manager->processLatestProducts($gridViewDTO);
        return $this->renderPartial('/_latestproductsgrid', ['gridViewDTO' => $gridViewDTO]);
    }
}