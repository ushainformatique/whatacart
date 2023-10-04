<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace usni\library\modules\language\controllers;

use usni\library\web\actions\CreateAction;
use usni\library\web\actions\UpdateAction;
use usni\library\web\actions\IndexAction;
use usni\library\web\actions\ViewAction;
use usni\library\modules\language\web\actions\DeleteAction;
use usni\library\web\actions\BulkEditAction;
use usni\library\web\actions\BulkDeleteAction;
use yii\filters\AccessControl;
use usni\library\modules\language\models\Language;
use usni\library\web\actions\DeleteImageAction;
/**
 * DefaultController class file
 * 
 * @package usni\library\modules\language\controllers
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
                        'roles' => ['language.manage'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['language.view'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['language.create'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update', 'bulk-edit', 'delete-image'],
                        'roles' => ['language.update'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete', 'bulk-delete'],
                        'roles' => ['language.delete'],
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
                         'modelClass' => Language::className(),
                         'updateUrl'  => 'update',
                         'viewFile' => '/create'
                        ],
            'update' => ['class' => UpdateAction::className(),
                         'modelClass' => Language::className(),
                         'viewFile' => '/update'
                        ],
            'index'  => ['class' => IndexAction::className(),
                         'modelClass' => Language::className(),
                         'viewFile' => '/index'],
            'view'   => ['class' => ViewAction::className(),
                         'modelClass' => Language::className(),
                         'viewFile' => '/view'
                        ],
            'delete'   => ['class' => DeleteAction::className(),
                         'modelClass' => Language::className(),
                         'redirectUrl'=> 'index',
                         'permission' => 'language.deleteother'
                        ],
            'bulk-edit' => ['class' => BulkEditAction::className(),
                         'modelClass' => Language::className()
                        ],
            'bulk-delete' => ['class' => BulkDeleteAction::className(),
                              'modelClass' => Language::className()
                        ],
            'delete-image' => [
                            'class' => DeleteImageAction::className(),
                            'modelClass' => Language::className(),
                            'attribute' => 'image'
                        ]
        ];
    }
}