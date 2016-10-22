<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\controllers;

use frontend\controllers\BaseController;
use usni\UsniAdaptor;
use usni\library\modules\users\utils\UserUtil;
use customer\models\Customer;
use customer\models\CustomerEditForm;
use customer\utils\CustomerUtil;
use customer\views\front\ForgotPasswordView;
use customer\models\LoginForm;
use customer\views\front\ChangePasswordView;
use customer\models\ForgotPasswordForm;
use usni\library\utils\FlashUtil;
use frontend\utils\FrontUtil;
use customer\views\front\RegistrationView;
use customer\views\front\OrderView;
use yii\filters\AccessControl;
use customer\components\AccountBreadcrumb;
use common\modules\stores\utils\StoreUtil;
use common\modules\order\utils\OrderUtil;
use common\modules\order\utils\OrderPermissionUtil;
use usni\library\modules\users\models\Person;
use usni\library\utils\FileUploadUtil;
/**
 * SiteController class file.
 * 
 * @package customer\controllers
 */
class SiteController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors          = parent::behaviors();
        $excludedActions    = static::getExcludedActionsFromAccessControl();
        return array_merge($behaviors, [
            'access' => [
                'class' => AccessControl::className(),
                'except' => $excludedActions,
                'rules' => [
                    // allow authenticated users
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // everything else is denied by default
                ],
            ],
        ]);
    }
    
    /**
     * Action Logout.
     * @return void
     */
    public function actionLogout()
    {
        UsniAdaptor::app()->user->logout(true);
        UsniAdaptor::app()->cache->flush();
        $this->redirect(UsniAdaptor::createUrl('/customer/site/login'));
    }

    /**
     * Action Login.
     * @return void
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        $isGuest = UsniAdaptor::app()->user->isGuest;
        if(!$isGuest)
        {
            return $this->goHome();
        }
        else
        {
            if (isset($_POST['LoginForm']))
            {
                $model->attributes = $_POST['LoginForm'];
                if ($model->validate())
                {
                    if ($model->login())
                    {
                        return $this->goHome();
                    }
                }
            }
            $title              = UsniAdaptor::t('users', 'Login');
            $breadcrumbView     = new AccountBreadcrumb(['page' => UsniAdaptor::t('users', 'Login')]);
            $this->getView()->params['breadcrumbs'] = $breadcrumbView->getBreadcrumbLinks();
            $loginView          = UsniAdaptor::app()->getModule('customer')->viewHelper->getInstance('loginPageView', ['model' => $model]);
            $content            = $this->renderInnerContent([$loginView]);

            return $this->render(FrontUtil::getDefaultInnerLayout(), ['content' => $content, 'title' => $title]);
        }
    }
    
    /**
     * Action forgot password.
     * @return void
     */
    public function actionForgotPassword()
    {
        $model              = new ForgotPasswordForm();
        $model->scenario    = 'forgotpassword';
        $isGuest = UsniAdaptor::app()->user->isGuest;
        if(!$isGuest)
        {
            return $this->goHome();
        }
        $postData = UsniAdaptor::app()->request->post();
        if ($model->load($postData))
        {
            $person = CustomerUtil::getCustomerByEmail($model->email);
            if ($person != false)
            {
                if ($person['status'] == Customer::STATUS_ACTIVE)
                {
                    $model->user = $person;
                    $model->sendMail();
                    FlashUtil::setMessage('forgotpassword', UsniAdaptor::t('userflash', 'Your login credentials are sent on registered email address.'));
                }
                else
                {
                    FlashUtil::setMessage('activationstatusissue', UsniAdaptor::t('userflash', 'Your account is not in active status.'));
                }
            }
            else
            {
                FlashUtil::setMessage('notregisteredmailid', UsniAdaptor::t('userflash', 'The given email is not registered with us. Please enter a valid email.'));
            }
        }
        $model->email       = null;
        $breadcrumbView     = new AccountBreadcrumb(['page' => UsniAdaptor::t('users', 'Forgot Password')]);
        $this->getView()->params['breadcrumbs'] = $breadcrumbView->getBreadcrumbLinks();
        $this->getView()->title = UsniAdaptor::t('users', 'Forgot Password') . '?';
        $view               = new ForgotPasswordView(['model' => $model]);
        $content            = $this->renderInnerContent([$view]);
        return $this->render(FrontUtil::getDefaultInnerLayout(), ['content' => $content]);
    }
    
    /**
     * Process user save,
     * @param Model $model
     * @return string
     */
    public function processCustomerSave($model)
    {
        $scenario           = $model->scenario;
        $postData           = UsniAdaptor::app()->request->post();
        if ($model->customer->load($postData) 
                && $model->person->load($postData)
                    && $model->address->load($postData))
        {
            if(CustomerUtil::validateAndSaveCustomerData($model))
            {
                $model->customer->newPassword = $model->customer->password;
                if($scenario == 'editprofile')
                {
                    $this->redirect(UsniAdaptor::createUrl('customer/site/my-account'));
                }
                else
                {
                    $model->sendMail();
                    FlashUtil::setMessage('userregistration', UsniAdaptor::t('userflash', 'You have successfully registered with the system. An activation email has been sent at your registered email address.'));
                    return $this->redirect(UsniAdaptor::createUrl('customer/site/login'));
                }
            }
        }
        if($scenario == 'editprofile')
        {
            $this->getView()->title = UsniAdaptor::t('users', 'Edit Profile');
            $breadcrumbView     = new AccountBreadcrumb(['page' => $this->getView()->title]);
        }
        else
        {
            $this->getView()->title = UsniAdaptor::t('users', 'Register');
            $breadcrumbView     = new AccountBreadcrumb(['page' => $this->getView()->title]);
        }
        $this->getView()->params['breadcrumbs'] = $breadcrumbView->getBreadcrumbLinks();
        $customerEditView   = new RegistrationView(['model' => $model]);
        $content            = $this->renderInnerContent([$customerEditView]);
        return $this->render(FrontUtil::getDefaultInnerLayout(), ['content' => $content]);
    }

    /**
     * Action register.
     * @return void
     */
    public function actionRegister()
    {
        if(UsniAdaptor::app()->user->isGuest)
        {
            $model  = $this->getEditFormInstance('registration');
            return $this->processCustomerSave($model);
        }
        else
        {
            $customer = UsniAdaptor::app()->user->getUserModel();
            $this->redirect(UsniAdaptor::createUrl('/customer/site/edit-profile', ['id' => $customer->id]));
        } 
    }
    
    /**
     * Get edit form instance
     * 
     * @param $scenario string
     * @return string
     */
    protected function getEditFormInstance($scenario)
    {
        return new CustomerEditForm(['scenario' => $scenario]);
    }
    
    /**
     * Action EditProfile.
     * @return void
     */
    public function actionEditProfile($id = null)
    {
        if(UsniAdaptor::app()->user->isGuest == false)
        {
            if($id == null)
            {
                $id = UsniAdaptor::app()->user->getUserModel()->id;
            }
            $model              = new CustomerEditForm(['scenario' => 'editprofile']);
            $customer           = Customer::findOne($id);
            $model->customer    = $customer;
            $model->customer->scenario = 'editprofile';
            $model->person      = $customer->person;
            $model->person->scenario = 'editprofile';
            $model->address      = $customer->address;
            $model->address->scenario = 'editprofile';
            return $this->processCustomerSave($model);
        }
        else
        {
            $this->redirect(UsniAdaptor::createUrl('/site/default/index'));
        }
    }

    /**
     * Action ViewProfile
     * @return void
     */
    public function actionMyAccount()
    {
        $viewHelper         = UsniAdaptor::app()->getModule('customer')->viewHelper;
        $view               = $viewHelper->getInstance('myProfileView');
        $breadcrumbView     = new AccountBreadcrumb(['page' => UsniAdaptor::t('users', 'My Account')]);
        $this->getView()->title = UsniAdaptor::t('customer', 'My Account');
        $this->getView()->params['breadcrumbs'] = $breadcrumbView->getBreadcrumbLinks();
        $content = $this->renderInnerContent([$view]);
        return $this->render(FrontUtil::getDefaultInnerLayout(), ['content' => $content]);
    }
    
    /**
     * Change password for user.
     * @return void
     */
    public function actionChangePassword()
    {
        $customer = UsniAdaptor::app()->user->getUserModel();
        $model    = CustomerUtil::processChangePasswordAction($customer->id, UsniAdaptor::app()->request->post(), UsniAdaptor::app()->user->getUserModel());
        if ($model === false)
        {
            $this->goHome();
        }
        $this->getView()->title = UsniAdaptor::t('users', 'Change Password');
        $breadcrumbView         = new AccountBreadcrumb(['page' => $this->getView()->title]);
        $this->getView()->params['breadcrumbs'] = $breadcrumbView->getBreadcrumbLinks();
        FlashUtil::setMessage('passwordinstructions', UserUtil::getPasswordInstructions());
        $view       = new ChangePasswordView(['model' => $model]);
        $content    = $this->renderInnerContent([$view]);
        return $this->render(FrontUtil::getDefaultInnerLayout(), ['content' => $content]);
    }

    /**
     * Get page titles.
     * @return array
     */
    public function pageTitles()
    {
        return [
            'login'             => UsniAdaptor::t('users', 'Login'),
            'register'          => UsniAdaptor::t('customer', 'Register Account'),
            'editProfile'       => UsniAdaptor::t('users', 'Edit Profile'),
            'viewProfile'       => UsniAdaptor::t('users', 'View Profile'),
            'changePassword'    => UsniAdaptor::t('users', 'Change Password'),
            'forgotPassword'    => UsniAdaptor::t('users', 'Forgot Password')
        ];
    }

    /**
     * Validate email address.
     * @param $hash string
     * @param $email string
     * @return void
     */
    public function actionValidateEmailAddress($hash, $email)
    {
        $tableName  = UsniAdaptor::tablePrefix() . 'customer';
        if (UsniAdaptor::app()->user->getIsGuest())
        {
            $user = UserUtil::activateUser($tableName, $hash, $email);  
            if ($user !== false)
            {
                UserUtil::setDefaultAuthAssignments($user['username'], 'customer');
                $message = UsniAdaptor::t('users', 'Your email has been validated, Please login to continue.');
            }
            else
            {
                $message = UsniAdaptor::t('users', 'Your email validation fails. Please contact system admin.');
            }
            FlashUtil::setMessage('validateEmail', $message);
            return $this->redirect(UsniAdaptor::createUrl('customer/site/login'));
        }
        return $this->redirect(\yii\helpers\Url::home());
    }

    /**
     * Change user currency in the configuration.
     * @return void
     */
    public function actionSetCurrency()
    {
        if($_GET['currency'] != null)
        {
            $currManager = UsniAdaptor::app()->currencyManager;
            $currManager->setCookie($_GET['currency']);
        }
    }
    
    /**
     * Change store in the configuration.
     * @param string $id
     * @return void
     */
    public function actionSetStore($id)
    {
        if($id != null)
        {
            $store          = StoreUtil::getStoreById($id);
            $storeManager   = UsniAdaptor::app()->storeManager;
            if(!empty($store))
            {
                $storeManager->setCookie($id);
                $currency = StoreUtil::getLocalValue('currency', $id);
                UsniAdaptor::app()->currencyManager->setCookie($currency);
                $language = StoreUtil::getLocalValue('language', $id);
                $languageManager = UsniAdaptor::app()->languageManager;
                $languageManager->setCookie($language, $languageManager->applicationLanguageCookieName);
            }
            return $this->goHome();
        }
    }
    
    /**
     * Render order history
     * @return string
     */
    public function actionOrderHistory()
    {
        $this->getView()->title = UsniAdaptor::t('order', 'My Orders');
        $breadcrumbView     = new AccountBreadcrumb(['page' => $this->getView()->title]);
        $this->getView()->params['breadcrumbs'] = $breadcrumbView->getBreadcrumbLinks();
        $viewHelper         = UsniAdaptor::app()->getModule('customer')->viewHelper;
        $view               = $viewHelper->getInstance('myOrdersView');
        $content            = $this->renderInnerContent([$view]);
        return $this->render(FrontUtil::getDefaultInnerLayout(), ['content' => $content]);
    }
    
    /**
     * Render order view.
     * @param $id OrderId
     * @return string
     */
    public function actionOrderView($id)
    {
        $user               = UsniAdaptor::app()->user->getUserModel();
        $this->getView()->title = UsniAdaptor::t('order', 'View Order') . '#' . $id;
        $breadcrumbView     = new AccountBreadcrumb(['page' => $this->getView()->title]);
        $this->getView()->params['breadcrumbs'] = $breadcrumbView->getBreadcrumbLinks();
        $order              = OrderUtil::getOrder($id);
        if(empty($order))
        {
            throw new \yii\web\NotFoundHttpException();
        }
        $isPermissible      = OrderPermissionUtil::doesUserHavePermissionToPerformAction($order, $user, 'viewother');
        if($isPermissible)
        {
            $view               = new OrderView(['order' => $order]);
            $content            = $this->renderInnerContent([$view]);
            return $this->render(FrontUtil::getDefaultInnerLayout(), ['content' => $content]);
        }
        else
        {
            throw new \yii\web\ForbiddenHttpException(\Yii::t('yii', 'You are not allowed to perform this action.'));
        }
    }
    
    /**
     * Change language for the application.
     * @param string $language.
     * @return void.
     */
    public function actionChangeLanguage($language = null)
    {
        if($language != null)
        {
            UsniAdaptor::app()->languageManager->setCookie($language, UsniAdaptor::app()->languageManager->applicationLanguageCookieName);
        }
    }
    
    /**
     * Gets excluded actions from access control.
     * @return array
     */
    protected static function getExcludedActionsFromAccessControl()
    {
        return ['login', 'forgot-password', 'register', 'set-store', 'set-currency', 'change-language', 'validate-email-address'];
    }
    
    /**
     * Delete image.
     * @param integer $id.
     * @return void.
     */
    public function actionDeleteImage()
    {
        if(UsniAdaptor::app()->request->isAjax)
        {
            $id         = $_GET['id'];
            $model              = Person::findOne($id);
            $imageFieldName     = 'profile_image';
            $model->scenario    = 'deleteimage';
            FileUploadUtil::deleteImage($model, $imageFieldName, 150, 150);
            $model->$imageFieldName = null;
            $model->save();
        }
    }
}