<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\users\controllers;

use usni\UsniAdaptor;
use usni\library\modules\users\dto\UserFormDTO;
use usni\library\utils\FlashUtil;
use usni\library\modules\users\models\LoginForm;
use usni\library\utils\ArrayUtil;
use usni\library\modules\users\models\SettingsForm;
use usni\library\modules\users\business\Manager;
use usni\library\modules\users\dto\UserDetailViewDTO;
use usni\library\web\actions\IndexAction;
use usni\library\web\actions\CreateAction;
use usni\library\web\actions\UpdateAction;
use usni\library\web\actions\ViewAction;
use usni\library\web\actions\DeleteAction;
use usni\library\modules\users\models\User;
use usni\library\web\actions\BulkEditAction;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use usni\library\modules\users\dto\UserGridViewDTO;
use usni\library\dto\GridViewDTO;
use usni\library\web\actions\DeleteImageAction;
use usni\library\modules\users\models\Person;
use usni\library\modules\users\models\UserSearchForm;
use usni\library\web\actions\ChangePasswordAction;
/**
 * DefaultController for users.
 * 
 * @package usni\library\modules\users\controllers
 */
class DefaultController extends \usni\library\web\Controller
{
    /**
     * @var string 
     */
    public $loginView = '/login';
    
    /**
     * inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'except' => ['login', 'logout', 'validate-email-address'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['user.manage'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['user.view'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['user.create'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update', 'bulk-edit', 'delete-image'],
                        'roles' => ['user.update'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['user.delete'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['change-password'],
                        'roles' => ['user.change-password'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['change-status'],
                        'roles' => ['user.change-status'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['change-language', 'settings'],
                        'roles' => ['@'],
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
                         'modelClass' => User::className(),
                         'updateUrl'  => 'update',
                         'formDTOClass' => UserFormDTO::className(),
                         'viewFile' => '/create'
                        ],
            'update' => ['class' => UpdateAction::className(),
                         'modelClass' => User::className(),
                         'formDTOClass' => UserFormDTO::className(),
                         'viewFile' => '/update'
                        ],
            'index'  => ['class' => IndexAction::className(),
                         'modelClass' => User::className(),
                         'dtoClass' => UserGridViewDTO::className(),
                         'searchConfig' => ['class' => UserSearchForm::className()],
                         'viewFile' => '/index'],
            'view'   => ['class' => ViewAction::className(),
                         'modelClass' => User::className(),
                         'detailViewDTOClass' => UserDetailViewDTO::className(),
                         'viewFile' => '/view'
                        ],
            'delete'   => ['class' => DeleteAction::className(),
                           'modelClass' => User::className(),
                           'redirectUrl'=> 'index',
                           'permission' => 'user.deleteother'
                        ],
            'bulk-edit' => ['class' => BulkEditAction::className(),
                            'modelClass' => User::className()
                        ],
            'delete-image' => [
                            'class' => DeleteImageAction::className(),
                            'modelClass' => Person::className(),
                            'attribute' => 'profile_image'
                        ],
            'change-password' => [
                'class' => ChangePasswordAction::className(),
                'modelClass' => User::className(),
                'viewFile' => '/changepassword'
            ]
        ];
    }
    
    /**
     * Log in the user in the system.
     * @return string
     */
    public function actionLogin()
    {
        $this->layout       = '/login';
        $manager            = new Manager(['userId' => UsniAdaptor::app()->user->getId()]);
        $userFormDTO        = new UserFormDTO();
        $model              = new LoginForm();
        $postData           = UsniAdaptor::app()->request->post();
        $userFormDTO->setPostData($postData);
        $userFormDTO->setModel($model);
        if (UsniAdaptor::app()->user->isGuest)
        {
            $manager->processLogin($userFormDTO);
            if($userFormDTO->getIsTransactionSuccess())
            {
                return $this->goBack();
            }
        }
        else
        {
            return $this->redirect($this->resolveDefaultAfterLoginUrl());
        }
        return $this->render($this->loginView,['userFormDTO' => $userFormDTO]);
    }
    
    /**
     * Logout the user.
     * @return void
     */
    public function actionLogout()
    {
        UsniAdaptor::app()->user->logout(true);
        return $this->redirect(UsniAdaptor::createUrl('users/default/login'));
    }

    /**
     * Change user language in the configuration.
     * @param string $language
     * @return void
     */
    public function actionChangeLanguage($language = null)
    {
        if($language != null)
        {
            UsniAdaptor::app()->cookieManager->setLanguageCookie($language);
        }
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
                    'modelClass'    => User::className()
                ];
        $manager            = new Manager();
        $manager->userId    = UsniAdaptor::app()->user->getIdentity()->getId();
        $result             = $manager->processChangeStatus($data);
        if($result === false)
        {
            throw new ForbiddenHttpException(\Yii::t('yii','You are not authorized to perform this action.'));
        }
        return $this->redirect(UsniAdaptor::createUrl('users/default/index'));
    }
    
    /**
     * Comment settings.
     * @return void
     */
    public function actionSettings()
    {
        $model      = new SettingsForm();
        $formDTO    = new UserFormDTO();
        $postData   = ArrayUtil::getValue($_POST, 'SettingsForm');
        $formDTO->setPostData($postData);
        $formDTO->setModel($model);
        $manager    = new Manager();
        $result     = $manager->processSettings($formDTO);
        if($result === true)
        {
            FlashUtil::setMessage('success', UsniAdaptor::t('userflash', 'User settings are saved successfully.'));
            $this->refresh();
        }
        else
        {
            return $this->render('/settings',['model' => $model]);
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
        if(UsniAdaptor::app()->user->getIsGuest())
        {
            $manager    = new Manager();
            $result     = $manager->validateEmailAddress($hash, $email);
            if($result === true)
            {
                FlashUtil::setMessage('success', UsniAdaptor::t('users', 'Your email has been validated, Please login to continue.'));
            }
            else
            {
                FlashUtil::setMessage('info', UsniAdaptor::t('users', 'Your email validation fails. Please contact system admin.'));
            }
            return $this->redirect(UsniAdaptor::createUrl('users/default/login'));
        }
        return $this->redirect(\yii\helpers\Url::home());
    }
    
    /**
     * Get the latest products
     * @return string
     */
    public function actionLatest()
    {
        $manager = Manager::getInstance();
        $gridViewDTO = new GridViewDTO();
        $manager->processLatestUsers($gridViewDTO);
        return $this->renderPartial('/_latestusersgrid', ['gridViewDTO' => $gridViewDTO]);
    }
}