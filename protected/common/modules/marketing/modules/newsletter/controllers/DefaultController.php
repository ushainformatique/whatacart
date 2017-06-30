<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license http://www.gnu.org/licenses/gpl.html
 */
namespace newsletter\controllers;

use newsletter\models\Newsletter;
use usni\UsniAdaptor;
use usni\library\utils\FlashUtil;
use yii\filters\AccessControl;
use newsletter\dto\FormDTO;
use usni\library\web\actions\CreateAction;
use usni\library\web\actions\IndexAction;
use newsletter\business\Manager;
use usni\library\web\actions\ViewAction;
use usni\library\web\actions\DeleteAction;
use usni\library\web\actions\UpdateAction;
/**
 * DefaultController class file
 * 
 * @package newsletter\controllers
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
                        'actions' => ['index', 'send'],
                        'roles' => ['newsletter.manage'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['newsletter.view'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['newsletter.create'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete'],
                        'roles' => ['newsletter.delete'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update'],
                        'roles' => ['newsletter.update'],
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
                         'modelClass' => Newsletter::className(),
                         'updateUrl' => '/marketing/newsletter/default/update',
                         'formDTOClass' => FormDTO::className(),
                         'viewFile' => '/create'
                        ],
            'update' => ['class' => UpdateAction::className(),
                         'modelClass' => Newsletter::className(),
                         'formDTOClass' => FormDTO::className(),
                         'viewFile' => '/update'
                        ],
            'index'  => ['class' => IndexAction::className(),
                         'modelClass' => Newsletter::className(),
                         'viewFile' => '/index'
                        ],
            'view'   => ['class' => ViewAction::className(),
                         'modelClass' => Newsletter::className(),
                         'viewFile' => '/view'
                        ],
            'delete'   => ['class' => DeleteAction::className(),
                           'modelClass' => Newsletter::className(),
                           'redirectUrl'=> 'index',
                           'permission' => 'newsletter.deleteother'
                        ],
        ];
    }
    
    /**
     * Send newsletter  mails.
     * @return string
     */
    public function actionSend()
    {
        if(isset($_GET['selectedIds']))
        {
            Manager::getInstance()->processSend($_GET['selectedIds']);
            FlashUtil::setMessage('success', UsniAdaptor::t('newsletterflash', 'Newsletter has been sent successfully.'));
            return $this->redirect(UsniAdaptor::createUrl('/marketing/newsletter/default/index'));
        }
    }
}