<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\controllers;

use usni\library\components\UiAdminController;
use usni\UsniAdaptor;
use yii\web\ForbiddenHttpException;
use usni\library\utils\ArrayUtil;
use customer\models\Customer;
use customer\models\CustomerEditForm;
use customer\models\CustomerSearchForm;
use customer\views\CustomerBulkEditView;
use customer\views\ProfileEditView;
use usni\library\utils\FlashUtil;
use usni\library\modules\users\utils\UserUtil;
use customer\models\CustomerQuickCreateForm;
use customer\utils\CustomerPermissionUtil;
use customer\views\BaseChangePasswordFormView;
/**
 * DefaultController for customer.
 *
 * @package customer\controllers
 */
class DefaultController extends UiAdminController
{
    /**
     * Redricts to user manage. Index action will be invoked if there is no any action found in url. eg: '/index.php/users'
     * @return void
     */
    public function actionIndex()
    {
        $this->redirect(UsniAdaptor::createUrl('customer/default/manage'));
    }

    /**
     * @inheritdoc
     */
    public function actionCreate()
    {
        $model  = $this->getEditFormInstance('create');
        return $this->processCustomerSave($model);
    }
    
    /**
     * Process customer save,
     * @param Model $model
     * @return string
     */
    public function processCustomerSave($model)
    {
        $scenario           = $model->scenario;
        $customerUtil       = static::getCustomerUtil();
        $postData           = UsniAdaptor::app()->request->post();
        if($model->person->profile_image != null)
        {
            $model->person->savedImage = $model->person->profile_image;
        }
        if ($model->customer->load($postData) 
                && $model->person->load($postData) 
                    && $model->address->load($postData))
        {
            if($customerUtil::validateAndSaveCustomerData($model))
            {
                if($model->customer->status != Customer::STATUS_INACTIVE && $scenario == 'create')
                {
                    $model->sendMail();
                }
                return $this->redirect(UsniAdaptor::createUrl('customer/default/manage'));
            }
        }
        $this->setBreadCrumbs($model);
        $profileEditView    = static::getProfileEditView();
        $customerEditView   = new $profileEditView(['model' => $model]);
        $content            = $this->renderColumnContent([$customerEditView]);
        return $this->render($this->getDefaultLayout(), ['content' => $content]);
    }
    
    /**
     * @inheritdoc
     */
    public function actionUpdate($id)
    {
        $model              = $this->getEditFormInstance('update');
        $model->scenario    = 'update';
        $customer           = Customer::findOne($id);
        $model->customer    = $customer;
        $model->person      = $customer->person;
        $model->address     = $customer->address;
        $model->customer->scenario = 'update';
        $model->person->scenario   = 'update';
        $model->address->scenario  = 'update';
        return $this->processCustomerSave($model);
    }

    /**
     * Change password for user.
     * @param integer $id
     * @return void
     */
    public function actionChangePassword($id)
    {
        $customerUtil   = static::getCustomerUtil();
        $model          = $customerUtil::processChangePasswordAction($id, UsniAdaptor::app()->request->post(), UsniAdaptor::app()->user->getUserModel());
        if($model === false)
        {
            $this->redirect(UsniAdaptor::createUrl('customer/default/manage'));
        }
        $breadcrumbs      = [
                                [
                                    'label' => Customer::getLabel(2),
                                    'url'   => UsniAdaptor::createUrl('customer/default/manage')
                                ],
                                [
                                    'label' => $model['user']['username'],
                                    'url'   => UsniAdaptor::createUrl('customer/default/view', ['id' => $model['user']['id']])
                                ],
                                [
                                    'label' => UsniAdaptor::t('users','Change Password'),
                                ]
                            ];
        $this->getView()->params['breadcrumbs']  = $breadcrumbs;
        FlashUtil::setMessage('passwordinstructions', UserUtil::getPasswordInstructions());
        $changePasswordView     = new BaseChangePasswordFormView($model);
        $content                = $this->renderColumnContent([$changePasswordView]);
        return $this->render($this->getDefaultLayout(), ['content' => $content]);
    }

    /**
     * @inheritdoc
     */
    public function actionDelete($id)
    {
        $this->processDelete($id);
    }

    /**
     * @inheritdoc
     */
    public function pageTitles()
    {
        return array(
            'create'         => UsniAdaptor::t('application','Create') . ' ' . Customer::getLabel(1),
            'update'         => UsniAdaptor::t('application','Update') . ' ' . Customer::getLabel(1),
            'view'           => UsniAdaptor::t('application','View') . ' ' . Customer::getLabel(1),
            'manage'         => UsniAdaptor::t('customer', 'Manage Customers'),
            'changePassword' => UsniAdaptor::t('users', 'Change Password'),
            'forgotPassword' => UsniAdaptor::t('users', 'Forgot Password')
        );
    }

    /**
     * @inheritdoc
     */
    protected function resolveModelClassName()
    {
        return Customer::className();
    }

    /**
     * @inheritdoc
     */
    protected function getActionToPermissionsMap()
    {
        $actionToPermissionsMap = parent::getActionToPermissionsMap();
        $additionalPermissions  = [
                                    'change-password' => 'customer.change-password',
                                    'change-status'  => 'customer.update'
                                  ];
        return array_merge($additionalPermissions, $actionToPermissionsMap);
    }

    /**
     * @inheritdoc
     */
    protected function resolveModel(& $config = [])
    {
        $scenario       = ArrayUtil::getValue('scenario', $config, 'create');
        $id             = ArrayUtil::getValue('id', $config);
        $modelClassName = ArrayUtil::getValue('modelClassName', $config, $this->resolveModelClassName());
        $model          = parent::resolveModel($config);
        $user           = UsniAdaptor::app()->user->getUserModel();
        if($scenario == 'changepassword')
        {
            $model = $this->loadModel($modelClassName, $id);
            if(CustomerPermissionUtil::doesUserHavePermissionToPerformAction($model, $user, 'customer.change-password') === false)
            {
                throw new ForbiddenHttpException(\Yii::t('yii','You are not authorized to perform this action.'));
            }
        }
        return $model;
    }

    /**
     * Get search form model class name.
     * @param Model $model
     * @return string
     */
    protected function getSearchFormModelClassName($model)
    {
        return CustomerSearchForm::className();
    }
    
    /**
     * @inheritdoc
     */
    protected function updateModelAttributeWithBulkEdit($modelClassName, $id, $key, $value)
    {
        $user               = Customer::findOne($id);
        $user->scenario     = 'bulkedit';
        UserUtil::updateModelAttributeWithBulkEdit($modelClassName, $key, $value, $user);
    }
    
    /**
     * Change status.
     * @param int $id
     * @param int $status
     * @return void
     */
    public function actionChangeStatus($id, $status)
    {
        $customer = Customer::findOne($id);
        $customer->status = $status;
        $customer->save();
        return $this->renderGridView();
    }
    
    /**
     * @inheritdoc
     */
    protected function resolveBulkEditViewClassName()
    {
        return CustomerBulkEditView::className();
    }
    
    /**
     * Get edit form instance
     * 
     * @param $scenario string
     * @return string
     */
    protected function getEditFormInstance($scenario = 'create')
    {
        return new CustomerEditForm(['scenario' => $scenario]);
    }
    
    /**
     * Get customer util
     * @return string
     */
    protected static function getCustomerUtil()
    {
        return 'customer\utils\CustomerUtil';
    }
    
    /**
     * Get customer quick create form
     * @return string
     */
    protected static function getCustomerQuickCreateForm()
    {
        return CustomerQuickCreateForm::className();
    }
    
    /**
     * Get customer profile edit view
     * @return string
     */
    protected static function getProfileEditView()
    {
        return ProfileEditView::className();
    }
}
?>