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
use customer\models\LoginForm;
use usni\library\utils\FlashUtil;
use yii\filters\AccessControl;
use usni\library\modules\users\models\Person;
use usni\library\utils\FileUploadUtil;
use common\modules\stores\dao\StoreDAO;
use customer\dto\FormDTO;
use customer\business\SiteManager;
use usni\library\utils\ArrayUtil;
use yii\web\ForbiddenHttpException;
use yii\helpers\Url;
use common\modules\order\dto\GridViewDTO as OrderGridViewDTO;
use usni\library\dto\GridViewDTO;
use yii\web\NotFoundHttpException;
use common\modules\order\dto\DetailViewDTO;
use yii\base\InvalidParamException;
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
        if(UsniAdaptor::app()->user->isGuest == false)
        {
            return $this->goHome();
        }
        $formDTO    = new FormDTO();
        $formDTO->setModel(new LoginForm());
        $formDTO->setPostData($_POST);
        SiteManager::getInstance()->processLogin($formDTO);
        if($formDTO->getIsTransactionSuccess() == true)
        {
            return $this->goHome();
        }
        else
        {
            return $this->render('/front/login', ['formDTO' => $formDTO]);
        }
    }
    
    /**
     * Action forgot password.
     * @return void
     */
    public function actionForgotPassword()
    {
        if(UsniAdaptor::app()->user->isGuest == false)
        {
            return $this->goHome();
        }
        $formDTO = new FormDTO();
        $postData = UsniAdaptor::app()->request->post();
        $formDTO->setPostData($postData);
        SiteManager::getInstance()->processForgotPassword($formDTO);
        if($formDTO->getActivationStatusIssue() == true)
        {
            FlashUtil::setMessage('warning', UsniAdaptor::t('userflash', 'Your account is not in active status.'));
        }
        elseif($formDTO->getNotRegisteredEmailId() == true)
        {
            FlashUtil::setMessage('danger', UsniAdaptor::t('userflash', 'The given email is not registered with us. Please enter a valid email.'));
        }
        elseif($formDTO->getIsTransactionSuccess() == true)
        {
            FlashUtil::setMessage('success', UsniAdaptor::t('userflash', 'Your login credentials are sent on registered email address.'));
        }
        return $this->render('/front/forgotpassword', ['formDTO' => $formDTO]);
    }
    
    /**
     * Action register.
     * @return void
     */
    public function actionRegister()
    {
        if(UsniAdaptor::app()->user->isGuest)
        {
            $formDTO = new FormDTO();
            $formDTO->setScenario('registration');
            $postData = UsniAdaptor::app()->request->post();
            $formDTO->setPostData($postData);
            $manager = new SiteManager();
            $manager->processEdit($formDTO);
            if($formDTO->getIsTransactionSuccess() == true)
            {
                FlashUtil::setMessage('success', UsniAdaptor::t('userflash', 'You have successfully registered with the system. An activation email has been sent at your registered email address.'));
                return $this->redirect(UsniAdaptor::createUrl('customer/site/login'));
            }
            else
            {
                return $this->render('/front/registration', ['formDTO' => $formDTO]);
            }
        }
        else
        {
            $customer = UsniAdaptor::app()->user->getIdentity();
            $this->redirect(UsniAdaptor::createUrl('/customer/site/edit-profile', ['id' => $customer->id]));
        } 
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
                $id = UsniAdaptor::app()->user->getIdentity()->id;
            }
            $formDTO = new FormDTO();
            $formDTO->setScenario('editprofile');
            $postData = UsniAdaptor::app()->request->post();
            $formDTO->setPostData($postData);
            $formDTO->setId($id);
            $manager = new SiteManager();
            $manager->processEdit($formDTO);
            if($formDTO->getIsTransactionSuccess())
            {
                FlashUtil::setMessage('success', UsniAdaptor::t('applicationflash', 'Record has been updated successfully.'));
            }
            return $this->render('/front/editprofile', ['formDTO' => $formDTO]);
        }
        $this->redirect(UsniAdaptor::createUrl('/site/default/index'));
    }

    /**
     * My account dashboard.
     * @return void
     */
    public function actionMyAccount()
    {
        return $this->render('/front/myaccount', ['model' => UsniAdaptor::app()->user->getIdentity()]);
    }
    
    /**
     * Change password for user.
     * @return void
     */
    public function actionChangePassword()
    {
        $customer   = UsniAdaptor::app()->user->getIdentity();
        $postData   = ArrayUtil::getValue($_POST, ['ChangePasswordForm']);
        $formDTO    = new FormDTO();
        $formDTO->setPostData($postData);
        $formDTO->setId($customer->id);
        $formDTO->setModelClassName(Customer::className());
        $manager    = new SiteManager();
        $manager->processChangePassword($formDTO);
        UsniAdaptor::app()->getSession()->setFlash('warning', UserUtil::getPasswordInstructions());
        if($formDTO->getIsTransactionSuccess() === true)
        {
            FlashUtil::setMessage('success', UsniAdaptor::t('userflash', 'Password has been changed successfully.'));
            return $this->refresh();
        }
        elseif($formDTO->getIsTransactionSuccess() === false)
        {
            throw new ForbiddenHttpException(\Yii::t('yii','You are not authorized to perform this action.'));
        }
        else
        {
            return $this->render('/front/changepassword', ['formDTO' => $formDTO]);
        }
    }

    /**
     * Validate email address.
     * @param $hash string
     * @param $email string
     * @return void
     */
    public function actionValidateEmailAddress($hash, $email)
    {
        if (UsniAdaptor::app()->user->getIsGuest())
        {
            $result = SiteManager::getInstance()->processValidateEmailAddress($hash, $email);
            if($result == true)
            {
                FlashUtil::setMessage('success', UsniAdaptor::t('users', 'Your email has been validated, Please login to continue.'));
            }
            elseif($result == false)
            {
                FlashUtil::setMessage('error', UsniAdaptor::t('users', 'Your email validation fails. Please contact system admin.'));
            }
            return $this->redirect(UsniAdaptor::createUrl('customer/site/login'));
        }
        return $this->redirect(Url::home());
    }

    /**
     * Change user currency in the configuration.
     * @param string $currency
     * @return void
     */
    public function actionSetCurrency($currency)
    {
        if($currency != null)
        {
            UsniAdaptor::app()->cookieManager->setCurrencyCookie($currency);
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
            $store          = StoreDAO::getById($id, UsniAdaptor::app()->languageManager->selectedLanguage);
            if(!empty($store))
            {
                UsniAdaptor::app()->cookieManager->setStoreCookie($id);
                $currency = UsniAdaptor::app()->storeManager->getLocalValue('currency', $id);
                UsniAdaptor::app()->cookieManager->setCurrencyCookie($currency);
                $language = UsniAdaptor::app()->storeManager->getLocalValue('language', $id);
                UsniAdaptor::app()->cookieManager->setLanguageCookie($language);
            }
            return $this->redirect(UsniAdaptor::app()->request->referrer);
        }
    }
    
    /**
     * Render order history
     * @return string
     */
    public function actionOrderHistory()
    {
        $gridViewDTO = new OrderGridViewDTO();
        SiteManager::getInstance()->processOrderHistory($gridViewDTO, $_GET);
        return $this->render('/front/order/myorders', ['gridViewDTO' => $gridViewDTO]);
    }
    
    /**
     * Render order view.
     * @param $id OrderId
     * @return string
     */
    public function actionOrderView($id)
    {
        $detailViewDTO = new DetailViewDTO();
        $detailViewDTO->setId($id);
        SiteManager::getInstance()->processOrderView($detailViewDTO, UsniAdaptor::app()->storeManager->selectedStoreId);
        if($detailViewDTO->getEmptyOrder() == true)
        {
            throw new InvalidParamException(UsniAdaptor::t('order', "Invalid order"));
        }
        elseif($detailViewDTO->getIsValidOrder() == true)
        {
            return $this->render('/front/order/view', ['detailViewDTO' => $detailViewDTO]);
        }
        else
        {
            throw new InvalidParamException(UsniAdaptor::t('order', "Invalid order"));
        }
    }
    
    /**
     * Change language for the application.
     * @param string $language
     * @return void.
     */
    public function actionChangeLanguage($language = null)
    {
        if($language != null)
        {
            UsniAdaptor::app()->cookieManager->setLanguageCookie($language);
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
    
    /**
     * Render my downloads
     * @return string
     */
    public function actionDownloads()
    {
        $gridViewDTO = new GridViewDTO();
        SiteManager::getInstance()->processDownloads($gridViewDTO, $_GET);
        return $this->render('/front/mydownloads', ['gridViewDTO' => $gridViewDTO]);
    }
    
    /**
     * Download file.
     * @param int $id
     * @param int $orderId
     */
    public function actionDownload($id, $orderId)
    {
        $result = SiteManager::getInstance()->processDownload($id, $orderId, UsniAdaptor::app()->storeManager->selectedStoreId);
        if($result == false)
        {
            throw new NotFoundHttpException();
        }
        if($result !== false && !empty($result))
        {
            FlashUtil::setMessage('error', $result);
            return $this->redirect('customer/site/downloads');
        }
    }
}