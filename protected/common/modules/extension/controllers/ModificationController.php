<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\extension\controllers;

use common\modules\extension\models\Extension;
use yii\filters\AccessControl;
use usni\library\web\actions\IndexAction;
use common\modules\extension\business\ModificationManager;
use usni\UsniAdaptor;
/**
 * ModificationController class file.
 * 
 * @package common\modules\extension\controllers
 */
class ModificationController extends \usni\library\web\Controller
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
        $managerConfig = ['class'     => ModificationManager::className()];
        return [
            'index'  => ['class' => IndexAction::className(),
                         'modelClass' => Extension::className(),
                         'managerConfig' => $managerConfig,
                         'viewFile' =>'/modificationindex'
                        ]
        ];
    }
    
    /**
     * Change status for modification.
     * @param integer $id
     * @param integer $status
     * @return string
     */
    public function actionChangeStatus($id, $status)
    {
        ModificationManager::getInstance()->processChangeStatus($id, $status);
        return $this->redirect(UsniAdaptor::createUrl('extension/modification/index'));
    }
}