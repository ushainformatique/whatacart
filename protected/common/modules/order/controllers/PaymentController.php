<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\controllers;

use usni\UsniAdaptor;
use common\modules\order\models\Order;
use common\modules\order\business\Manager as OrderBusinessManager;
use common\modules\order\dto\PaymentFormDTO;
use common\modules\order\business\PaymentManager;
use common\modules\order\dto\PaymentGridViewDTO;
use common\modules\order\models\OrderPaymentTransactionMapSearch;
use yii\filters\AccessControl;
use common\modules\order\models\OrderPaymentTransactionMap;
use usni\library\web\actions\DeleteAction;
use usni\library\web\actions\BulkDeleteAction;
/**
 * PaymentController class file
 * 
 * @package common\modules\order\controllers
 */
class PaymentController extends \usni\library\web\Controller
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
                        'actions' => ['add', 'index'],
                        'roles' => ['order.manage'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete', 'bulk-delete'],
                        'roles' => ['order.delete'],
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
            'delete'   => ['class' => DeleteAction::className(),
                            'modelClass' => OrderPaymentTransactionMap::className(),
                            'redirectUrl'=> '/order/payment/index',
                            'permission' => 'order.deleteother'
                          ],
            'bulk-delete' => ['class' => BulkDeleteAction::className(),
                              'modelClass' => OrderPaymentTransactionMap::className(),
                              'managerConfig' => ['class' => PaymentManager::className()]
                        ]
        ];
    }
    
    /**
     * Adds payment
     * @param int $orderId
     * @return string
     */
    public function actionAdd($orderId)
    {
        $order = Order::findOne($orderId);
        if($order == null)
        {
            $this->redirect(UsniAdaptor::createUrl('order/default/index'));
        }
        $isValidOrderId = OrderBusinessManager::getInstance()->isValidOrderId($orderId);
        if(!$isValidOrderId)
        {
            throw new \yii\web\NotFoundHttpException();
        }
        $paymentFormDTO = new PaymentFormDTO();
        $paymentFormDTO->setOrder($order);
        $paymentFormDTO->setPostData(UsniAdaptor::app()->request->post());
        PaymentManager::getInstance()->processSelectPayment($paymentFormDTO);
        if($paymentFormDTO->getIsTransactionSuccess())
        {
            return $this->redirect(UsniAdaptor::createUrl('payment/' . $paymentFormDTO->getModel()->payment_type . '/transaction/add', ['orderId' => $orderId]));
        }
        return $this->render('/payment/selectpaymentedit', ['formDTO' => $paymentFormDTO]);
    }
    
    /**
     * Manages models.
     * @param int $orderId
     * @return string
     */
    public function actionIndex($orderId = null)
    {
        $searchModelInstance = new OrderPaymentTransactionMapSearch();
        if($orderId != null)
        {
            $isValidOrderId = OrderBusinessManager::getInstance()->isValidOrderId($orderId);
            if(!$isValidOrderId)
            {
                throw new \yii\web\NotFoundHttpException();
            }
            $searchModelInstance = new OrderPaymentTransactionMapSearch(['order_id' => $orderId]);
        }
        $gridViewDTO    = new PaymentGridViewDTO();
        $gridViewDTO->setQueryParams(UsniAdaptor::app()->request->queryParams);
        $gridViewDTO->setSearchModel($searchModelInstance);
        PaymentManager::getInstance()->processList($gridViewDTO);
        return $this->render('/payment/index', ['gridViewDTO' => $gridViewDTO]);
    }
}