<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\controllers;

use usni\UsniAdaptor;
use yii\web\ForbiddenHttpException;
use customer\models\Customer;
use yii\filters\AccessControl;
use customer\web\actions\IndexAction;
use usni\library\modules\users\dto\UserGridViewDTO;
use usni\library\web\actions\CreateAction;
use customer\dto\FormDTO;
use usni\library\web\actions\UpdateAction;
use usni\library\web\actions\BulkEditAction;
use customer\dto\CustomerDetailViewDTO;
use usni\library\web\actions\ViewAction;
use usni\library\web\actions\DeleteAction;
use customer\business\Manager;
use usni\library\dto\GridViewDTO;
use usni\library\web\actions\DeleteImageAction;
use usni\library\modules\users\models\Person;
use usni\library\web\actions\ChangePasswordAction;
/**
 * DefaultController for customer.
 *
 * @package customer\controllers
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
                        'roles' => ['customer.manage'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['customer.view'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['customer.create'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update', 'bulk-edit', 'delete-image'],
                        'roles' => ['customer.update'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['customer.delete'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['change-password'],
                        'roles' => ['customer.change-password'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['change-status'],
                        'roles' => ['customer.change-status'],
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
                         'modelClass' => Customer::className(),
                         'updateUrl'  => 'update',
                         'formDTOClass' => FormDTO::className(),
                         'viewFile' => '/create'
                        ],
            'update' => ['class' => UpdateAction::className(),
                         'modelClass' => Customer::className(),
                         'formDTOClass' => FormDTO::className(),
                         'viewFile' => '/update'
                        ],
            'index'  => ['class' => IndexAction::className(),
                         'modelClass' => Customer::className(),
                         'dtoClass' => UserGridViewDTO::className(),
                         'viewFile' => '/index'],
            'view'   => ['class' => ViewAction::className(),
                         'modelClass' => Customer::className(),
                         'detailViewDTOClass' => CustomerDetailViewDTO::className(),
                         'viewFile' => '/view'
                        ],
            'delete'   => ['class' => DeleteAction::className(),
                           'modelClass' => Customer::className(),
                           'redirectUrl'=> 'index',
                           'permission' => 'customer.deleteother'
                        ],
            'bulk-edit' => ['class' => BulkEditAction::className(),
                            'modelClass' => Customer::className()
                        ],
            'delete-image' => [
                            'class' => DeleteImageAction::className(),
                            'modelClass' => Person::className(),
                            'attribute' => 'profile_image'
                        ],
            'change-password' => [
                'class' => ChangePasswordAction::className(),
                'modelClass' => Customer::className(),
                'viewFile' => '/changepassword'
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
        $data = [
                    'id'            => $id,
                    'status'        => $status,
                    'modelClass'    => Customer::className()
                ];
        $manager            = new Manager();
        $manager->userId    = UsniAdaptor::app()->user->getIdentity()->getId();
        $result     = $manager->processChangeStatus($data);
        if($result === false)
        {
            throw new ForbiddenHttpException(\Yii::t('yii','You are not authorized to perform this action.'));
        }
        return $this->redirect(UsniAdaptor::createUrl('customer/default/index'));
    }
    
    /**
     * Get the latest products
     * @return string
     */
    public function actionLatest()
    {
        $manager = Manager::getInstance();
        $gridViewDTO = new GridViewDTO();
        $manager->processLatestCustomers($gridViewDTO);
        return $this->renderPartial('/_latestcustomersgrid', ['gridViewDTO' => $gridViewDTO]);
    }
}