<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\state\controllers;

use common\modules\localization\modules\state\models\State;
use yii\filters\AccessControl;
use usni\library\web\actions\CreateAction;
use usni\library\web\actions\UpdateAction;
use usni\library\web\actions\ViewAction;
use usni\library\web\actions\IndexAction;
use usni\library\web\actions\DeleteAction;
use usni\library\web\actions\BulkDeleteAction;
use usni\library\web\actions\BulkEditAction;
use common\modules\localization\modules\state\dto\FormDTO;
use common\modules\localization\modules\state\dto\GridViewDTO;
use common\modules\localization\modules\state\business\Manager as StateBusinessManager;
/**
 * DefaultController class file
 * 
 * @package common\modules\localization\modules\state\controllers
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
                        'roles' => ['state.manage'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['state.view'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['state.create'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update', 'bulk-edit'],
                        'roles' => ['state.update'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete', 'bulk-delete'],
                        'roles' => ['state.delete'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['get-states-by-country'],
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
                         'modelClass' => State::className(),
                         'updateUrl'  => 'update',
                         'formDTOClass' => FormDTO::className(),
                         'viewFile' => '/create'
                        ],
            'update' => ['class' => UpdateAction::className(),
                         'modelClass' => State::className(),
                         'formDTOClass' => FormDTO::className(),
                         'viewFile' => '/update'
                        ],
            'index'  => ['class' => IndexAction::className(),
                         'modelClass' => State::className(),
                         'dtoClass' => GridViewDTO::className(),
                         'viewFile' => '/index'
                        ],
            'view'   => ['class' => ViewAction::className(),
                         'modelClass' => State::className(),
                         'viewFile' => '/view'
                        ],
            'delete'   => ['class' => DeleteAction::className(),
                           'modelClass' => State::className(),
                           'redirectUrl'=> 'index',
                           'permission' => 'state.deleteother'
                        ],
            'bulk-edit' => ['class' => BulkEditAction::className(),
                            'modelClass' => State::className()
                        ],
            'bulk-delete' => ['class' => BulkDeleteAction::className(),
                              'modelClass' => State::className()
                        ],
        ];
    }
    
    /**
     * Get states by country.
     * 
     * @param integer $countryId
     * @return string
     */
    public function actionGetStatesByCountry($countryId)
    {
        return StateBusinessManager::getInstance()->processGetStateByCountry($countryId);
    }
}