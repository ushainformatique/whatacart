<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license http://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\marketing\controllers;

use usni\UsniAdaptor;
use usni\library\utils\FlashUtil;
use common\modules\marketing\business\Manager;
use common\modules\marketing\dto\FormDTO;
use usni\library\utils\ArrayUtil;
use yii\filters\AccessControl;
/**
 * SendMailController class file
 * 
 * @package common\modules\marketing\controllers
 */
class SendMailController extends \usni\library\web\Controller
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
                        'actions' => ['create'],
                        'roles' => ['marketing.mail'],
                    ]
                ],
            ],
        ];
    }
    
    /**
     * Create action.
     * @return string
     */
    public function actionCreate()
    {
        $formDTO    = new FormDTO();
        $formDTO->setPostData(ArrayUtil::getValue($_POST, 'SendMailForm'));
        $manager    = new Manager();
        $manager->processCreate($formDTO);
        if($formDTO->getIsTransactionSuccess() === true)
        {
            FlashUtil::setMessage('success', UsniAdaptor::t('marketing', 'Mail has been sent successfully.'));
            return $this->refresh();
        }
        else
        {
            return $this->render('/sendmail', ['formDTO' => $formDTO]);
        }
    }
}