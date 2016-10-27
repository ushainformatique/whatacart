<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\controllers;

use usni\library\components\UiAdminController;
use usni\UsniAdaptor;
use common\modules\order\models\Order;
use common\modules\order\models\AdminSelectPaymentMethodForm;
use common\modules\order\views\AdminSelectPaymentMethodView;
use common\modules\order\models\OrderPaymentTransactionMap;
use common\modules\order\views\OrderPaymentsGridView;
use common\modules\order\utils\OrderUtil;
/**
 * PaymentController class file
 * 
 * @package common\modules\order\controllers
 */
class PaymentController extends UiAdminController
{
    /**
     * @inheritdoc
     */
    protected function resolveModelClassName()
    {
        return OrderPaymentTransactionMap::className();
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
            $this->redirect(UsniAdaptor::createUrl('order/default/manage'));
        }
        if(OrderUtil::checkIfOrderAllowedToPerformAction($orderId) == false)
        {
            throw new \yii\web\NotFoundHttpException();
        }
        $paymentMethod = $order->orderPaymentDetails->payment_method;
        $model         = new AdminSelectPaymentMethodForm(['scenario' => 'create']);
        $postData      = UsniAdaptor::app()->request->post();
        if($model->load($postData))
        {
            return $this->redirect(UsniAdaptor::createUrl('payment/' . $model->payment_type . '/transaction/add', ['orderId' => $orderId]));
        }
        $model->payment_type = $paymentMethod;
        $breadcrumbs    = [
                                [
                                    'label' => UsniAdaptor::t('order', 'Manage Orders'),
                                    'url'   => UsniAdaptor::createUrl('order/default/manage')
                                ],
                                [
                                    'label' => UsniAdaptor::t('payment', 'Select Payment Method')
                                ]
                            ];
        $this->getView()->params['breadcrumbs']  = $breadcrumbs;
        $paymentView    = new AdminSelectPaymentMethodView($model);
        $content        = $this->renderColumnContent($paymentView->render());
        return $this->render($this->getDefaultLayout(), array('content' => $content));
    }
    
    /**
     * Manages models.
     * @param int $orderId
     * @return string
     */
    public function actionManage($orderId = null)
    {
        $breadcrumbs = [
                            [
                                'label' => UsniAdaptor::t('order', 'Manage Orders'),
                                'url'   => UsniAdaptor::createUrl('order/default/manage')
                            ],
                            [
                                'label' => UsniAdaptor::t('payment', 'Manage Payments')
                            ]
                        ];
        if($orderId == null)
        {
            return parent::actionManage(['breadcrumbs' => $breadcrumbs]);
        }
        else
        {
            if(OrderUtil::checkIfOrderAllowedToPerformAction($orderId) == false)
            {
                throw new \yii\web\NotFoundHttpException();
            }
            $_GET['OrderPaymentTransactionMapSearch']['order_id'] = $orderId;
            return parent::actionManage(['breadcrumbs' => $breadcrumbs]);
        }
    }
    
    /**
     * @inheritdoc
     */
    protected function resolveGridViewClassName($model)
    {
        return OrderPaymentsGridView::className();
    }
    
    /**
     * @inheritdoc
     */
    public function pageTitles()
    {
        return [
                    'add'         => UsniAdaptor::t('order','Select Payment Method'),
                    'manage'      => UsniAdaptor::t('payment', 'Manage Payments')
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getActionToPermissionsMap()
    {
        $permissionsMap                 = parent::getActionToPermissionsMap();
        $permissionsMap['add']          = 'order.manage';
        $permissionsMap['manage']       = 'order.manage';
        return $permissionsMap;
    }
}