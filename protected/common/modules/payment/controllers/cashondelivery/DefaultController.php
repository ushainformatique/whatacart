<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\controllers\cashondelivery;

use usni\UsniAdaptor;
use common\modules\payment\business\cashondelivery\Manager;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
/**
 * DefaultController class file
 *
 * @package common\modules\payment\controllers\cashondelivery
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
                        'actions' => ['change-status'],
                        'roles' => ['extension.update'],
                    ],
                ],
            ],
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
        $result     = Manager::getInstance()->processChangeStatus($id, $status);
        if($result == false)
        {
            throw new NotFoundHttpException();
        }
        return $this->redirect(UsniAdaptor::createUrl('payment/default/index'));
    }
}