<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\shipping\controllers;

use usni\UsniAdaptor;
use common\modules\extension\models\Extension;
use yii\filters\AccessControl;
use usni\library\web\actions\IndexAction;
use common\modules\shipping\business\Manager;
use usni\library\web\actions\DeleteAction;
/**
 * DefaultController class file
 * 
 * @package common\modules\shipping\controllers
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
                        'actions' => ['index', 'reload'],
                        'roles' => ['extension.manage'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['extension.delete'],
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
            'index'  => ['class' => IndexAction::className(),
                         'modelClass' => Extension::className(),
                         'viewFile' => '/index'
                        ],
            'delete'   => ['class' => DeleteAction::className(),
                         'modelClass' => Extension::className(),
                         'redirectUrl'=> '/shipping/default/index',
                         'permission' => 'extension.deleteother'
                        ]
        ];
    }
    
    /**
     * Reloads the shipping methods
     * @return void
     */
    public function actionReload()
    {
        Manager::getInstance()->processReload();
        return $this->redirect(UsniAdaptor::createUrl('shipping/default/index'));
    }
}