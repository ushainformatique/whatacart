<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\auth\controllers;

use usni\UsniAdaptor;
use usni\library\modules\auth\business\AuthManager;
use usni\library\modules\auth\models\AuthAssignmentForm;
use usni\library\utils\FlashUtil;
use usni\library\modules\auth\dto\AssignmentFormDTO;
use usni\library\modules\auth\business\Manager;
use yii\filters\AccessControl;
/**
 * PermissionController class file.
 * 
 * @package usni\library\modules\auth\components
 */
class PermissionController extends \usni\library\web\Controller
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
                        'actions' => ['manage'],
                        'roles' => ['auth.managepermissions'],
                    ]
                ],
            ],
        ];
    }
    
    /**
     * Manage permissions for group.
     * @param int $id
     * @param string $identityType
     * @return void
     */
    public function actionManage($id)
    {
        $formDTO    = new AssignmentFormDTO();
        $model      = new AuthAssignmentForm($id, AuthManager::TYPE_GROUP);
        $formDTO->setModel($model);
        $formDTO->setPostData(UsniAdaptor::app()->request->post());
        $manager    = new Manager();
        $manager->processPermissions($formDTO);
        if($formDTO->getIsTransactionSuccess())
        {
            FlashUtil::setMessage('success', UsniAdaptor::t('authflash', 'The permissions are saved successfully')); 
        }
        return $this->render('/_authassignment', ['formDTO' => $formDTO]);
    }
}