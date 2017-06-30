<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\enhancement\controllers;

use common\modules\extension\models\Extension;
use usni\UsniAdaptor;
use yii\filters\AccessControl;
use common\modules\enhancement\business\Manager;
use usni\library\web\actions\IndexAction;
/**
 * DefaultController class file
 *
 * @package common\modules\enhancement\controllers
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
                        'roles' => ['extension.manage'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['change-status'],
                        'roles' => ['extension.update'],
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
            'index'  => ['class' => IndexAction::className(),
                         'modelClass' => Extension::className(),
                         'viewFile' => '/index'
                        ]
        ];
    }
    
    /**
     * Change status.
     * @param int $id
     * @param int $status
     * @return void
     */
    public function actionChangeStatus($id, $status)
    {
        Manager::getInstance()->processChangeStatus($id, $status);
        return $this->redirect(UsniAdaptor::createUrl('enhancement/default/index'));
    }
}