<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\extension\controllers;

use usni\UsniAdaptor;
use usni\library\utils\FlashUtil;
use common\modules\extension\models\Extension;
use yii\filters\AccessControl;
use usni\library\web\actions\IndexAction;
use common\modules\extension\business\ExtensionManager;
/**
 * DefaultController class file
 *
 * @package common\modules\extension\controllers
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
                        'actions' => ['index', 'change-status', 'settings'],
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
                         'viewFile' =>'/extensionindex'
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
        ExtensionManager::getInstance()->processChangeStatus($id, $status);
        return $this->redirect(UsniAdaptor::createUrl('extension/default/index'));
    }
    
    /**
     * Settings for the extension
     * @param int $id
     * @return string
     */
    public function actionSettings($id)
    {
        $controllerPath = ExtensionManager::getInstance()->processSettings($id);
        if(!empty($controllerPath))
        {
            return $this->redirect(UsniAdaptor::createUrl($controllerPath));
        }
        FlashUtil::setMessage('error', UsniAdaptor::t('extensionflash', 'Settings route is missing in the configuration'));
        return $this->redirect(UsniAdaptor::createUrl('extension/default/index'));
    }
}