<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\controllers;

use usni\UsniAdaptor;
use common\modules\extension\models\Extension;
use usni\library\web\actions\IndexAction;
use yii\filters\AccessControl;
use common\modules\payment\business\Manager;
/**
 * DefaultController class file
 * 
 * @package common\modules\payment\controllers
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
     * Reloads the payment methods
     * @return void
     */
    public function actionReload()
    {
        $manager = Manager::getInstance();
        $manager->processReload();
        return $this->redirect(UsniAdaptor::createUrl('payment/default/index'));
    }
}