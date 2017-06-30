<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace products\controllers;

use products\models\ProductDownload;
use yii\filters\AccessControl;
use usni\library\web\actions\CreateAction;
use products\business\DownloadManager;
use usni\library\web\actions\UpdateAction;
use usni\library\web\actions\IndexAction;
use usni\library\web\actions\ViewAction;
use usni\library\web\actions\DeleteAction;
use usni\library\web\actions\DeleteImageAction;
use usni\library\utils\FileUploadUtil;
use usni\UsniAdaptor;
/**
 * DownloadController class file.
 * 
 * @package products\controllers
 */
class DownloadController extends \usni\library\web\Controller
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
                        'actions' => ['create'],
                        'roles' => ['product.create'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update', 'delete-image', 'delete-file'],
                        'roles' => ['product.update'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view', 'process'],
                        'roles' => ['product.view'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
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
        $managerConfig = ['class'    => DownloadManager::className()];
        return [
            'create' => ['class' => CreateAction::className(),
                         'modelClass' => ProductDownload::className(),
                         'updateUrl'  => 'update',
                         'viewFile' => '/productdownloads/create',
                         'managerConfig' => $managerConfig,
                        ],
            'update' => ['class' => UpdateAction::className(),
                         'modelClass' => ProductDownload::className(),
                         'viewFile' => '/productdownloads/update',
                         'managerConfig' => $managerConfig,
                        ],
            'index'  => ['class' => IndexAction::className(),
                         'modelClass' => ProductDownload::className(),
                         'viewFile' => '/productdownloads/index',
                         'managerConfig' => $managerConfig,
                        ],
            'view'   => ['class' => ViewAction::className(),
                         'modelClass' => ProductDownload::className(),
                         'viewFile' => '/productdownloads/view',
                         'managerConfig' => $managerConfig,
                        ],
            'delete'   => ['class' => DeleteAction::className(),
                           'modelClass' => ProductDownload::className(),
                           'redirectUrl'=> 'index',
                           'permission' => 'product.deleteother'
                        ],
            'delete-image' => [
                            'class' => DeleteImageAction::className(),
                            'modelClass' => ProductDownload::className(),
                            'attribute' => 'file'
                        ]
        ];
    }
    
    /**
     * Product download.
     * @param integer $id
     */
    public function actionProcess($id)
    {
        DownloadManager::getInstance()->processDownload($id);
    }
    
    /**
     * Delete file
     */
    public function actionDeleteFile()
    {
        if(UsniAdaptor::app()->request->isAjax)
        {
            $id          = $_GET['id'];
            $model       = ProductDownload::findOne($id);
            FileUploadUtil::deleteFile($model, 'file');
            $model->file = null;
            $model->save();   
        }
    }
}