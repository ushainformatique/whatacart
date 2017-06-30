<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\controllers;

use common\modules\stores\models\Store;
use common\modules\stores\models\StoreEditForm;
use usni\UsniAdaptor;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use common\modules\stores\business\Manager;
use common\modules\stores\dto\FormDTO;
use usni\library\web\actions\IndexAction;
use usni\library\web\actions\ViewAction;
use usni\library\web\actions\DeleteAction;
use usni\library\dto\GridViewDTO;
/**
 * DefaultController class file
 * 
 * @package common\modules\stores\controllers
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
                        'actions' => ['index', 'change-status', 'set-default-store'],
                        'roles' => ['store.manage'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['store.view'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['store.create'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['store.update'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['store.delete'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['set-store'],
                        'roles' => ['@'],
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
                         'modelClass' => Store::className(),
                         'dtoClass' => GridViewDTO::className(),
                         'viewFile' => '/index'
                        ],
            'view'   => ['class' => ViewAction::className(),
                         'modelClass' => Store::className(),
                         'viewFile' => '/view'
                        ],
            'delete'   => ['class' => DeleteAction::className(),
                         'modelClass' => Store::className(),
                         'redirectUrl'=> 'index',
                         'permission' => 'store.deleteother'
                        ]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function actionCreate()
    {
        $formDTO    = new FormDTO();
        $postData   = UsniAdaptor::app()->request->post();
        $model      = new StoreEditForm(['scenario' => 'create']);
        $manager    = new Manager();
        $formDTO->setModel($model);
        $formDTO->setPostData($postData);
        $formDTO->setScenario('create');
        $manager->processEdit($formDTO);
        if($formDTO->getIsTransactionSuccess())
        {
            $message = UsniAdaptor::t('applicationflash', 'Record has been saved successfully.');
            UsniAdaptor::app()->getSession()->setFlash('success', $message);
            return $this->redirect(UsniAdaptor::createUrl('stores/default/update', ['id' => $formDTO->getModel()->store->id]));
        }
        else
        {
            return $this->render('/create', ['formDTO' => $formDTO]);
        }
    }
    
    /**
     * @inheritdoc
     */
    public function actionUpdate($id)
    {
        $isPermissible      = true;
        $userId             = UsniAdaptor::app()->user->getId();
        $model              = new StoreEditForm();
        $model->scenario    = 'update';
        $store              = Store::findOne($id);
        if($userId != $store->created_by)
        {
            $isPermissible      = UsniAdaptor::app()->user->can('store.updateother');
        }
        if(!$isPermissible)
        {
            throw new ForbiddenHttpException(\Yii::t('yii','You are not authorized to perform this action.'));
        }
        else
        {
            $formDTO    = new FormDTO();
            $postData   = UsniAdaptor::app()->request->post();
            $model->store       = $store;
            if($store->billingAddress != null)
            {
                $model->billingAddress  = $store->billingAddress;
            }
            if($store->shippingAddress != null)
            {
                $model->shippingAddress  = $store->shippingAddress;
            }
            if($store->storeLocal != null)
            {
                $model->storeLocal  = $store->storeLocal;
            }
            if($store->storeSettings != null)
            {
                $model->storeSettings  = $store->storeSettings;
            }
            if($store->storeImage != null)
            {
                $model->storeImage  = $store->storeImage;
            }
            $model->store->setScenario('update');
            $model->storeImage->setScenario('update');
            $model->storeSettings->setScenario('update');
            $model->storeLocal->setScenario('update');
            $model->billingAddress->setScenario('update');
            $model->shippingAddress->setScenario('update');
            $manager    = new Manager();    
            $formDTO->setModel($model);
            $formDTO->setPostData($postData);
            $formDTO->setScenario('update');
            $manager->processEdit($formDTO);
            if($formDTO->getIsTransactionSuccess())
            {
                $message = UsniAdaptor::t('applicationflash', 'Record has been updated successfully.');
                UsniAdaptor::app()->getSession()->setFlash('success', $message);
                return $this->refresh();
            }
            else
            {
                return $this->render('/update', ['formDTO' => $formDTO]);
            }
        }
    }
    
    /**
     * Changes status for the store.
     * @param int $id
     * @param int $status
     */
    public function actionChangeStatus($id, $status)
    {
        $model          = Store::findOne($id);
        $model->status  = $status;
        $model->save();
        return $this->redirect(UsniAdaptor::createUrl('stores/default/index'));
    }

    /**
     * Set default store.
     * @param int $id
     */
    public function actionSetDefaultStore($id)
    {
        Store::updateAll(['is_default' => 0], 'is_default = 1');
        $model          = Store::findOne($id);
        $model->is_default = true;
        $model->save();
        return $this->redirect(UsniAdaptor::createUrl('stores/default/index'));
    }
    
    /**
     * Set store.
     * @return void.
     */
    public function actionSetStore()
    {
        if($_GET['id'] != null)
        {
            UsniAdaptor::app()->cookieManager->setStoreCookie($_GET['id']);
            $this->redirect(UsniAdaptor::app()->request->referrer);
        }
    }
}