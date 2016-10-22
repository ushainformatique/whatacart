<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\payment\controllers;

use usni\library\components\UiAdminController;
use usni\UsniAdaptor;
use common\modules\order\utils\OrderUtil;
use usni\library\utils\FlashUtil;
use common\modules\payment\utils\PaymentUtil;
/**
 * BaseTransactionController class file
 * 
 * @package common\modules\payment\controllers
 */
abstract class BaseTransactionController extends UiAdminController
{
    /**
     * @inheritdoc
     */
    protected function resolveModelClassName()
    {
        return null;
    }
    
    /**
     * Perform payment processing by payment method
     * @param int $orderId
     * @return string
     */
    public function actionAdd($orderId)
    {
        $modelClassName                     = $this->resolveModelClassName();
        $orderPaymentTransaction            = new $modelClassName(['scenario' => 'create']);
        $orderPaymentTransaction->order_id  = $orderId;
        $order                              = OrderUtil::getOrder($orderId);
        $postData           = UsniAdaptor::app()->request->post();
        if($orderPaymentTransaction->load($postData))
        {
            $transaction = UsniAdaptor::app()->db->beginTransaction();
            PaymentUtil::validateAndSaveOrderPaymentTransaction($orderPaymentTransaction, $this->getType());
            $transaction->commit();
            $orderPaymentTransaction->transaction_id    = null;
            $orderPaymentTransaction->transaction_fee   = 0;
            FlashUtil::setMessage('transactionSuccess', UsniAdaptor::t('order', 'The transaction is saved successfully'));
        }
        $orderPaymentTransaction->totalAmount       = $order['total_including_tax'] + $order['shipping_fee'];
        $orderPaymentTransaction->alreadyPaidAmount = OrderUtil::getAlreadyPaidAmountForOrder($order['id']);
        $orderPaymentTransaction->pendingAmount     = $orderPaymentTransaction->totalAmount - $orderPaymentTransaction->alreadyPaidAmount;
        $breadcrumbs    = [
                                [
                                    'label' => UsniAdaptor::t('order', 'Manage Orders'),
                                    'url'   => UsniAdaptor::createUrl('order/default/manage')
                                ],
                                [
                                    'label' => UsniAdaptor::t('payment', 'Add Payment')
                                ]
                            ];
        $this->getView()->params['breadcrumbs']  = $breadcrumbs;
        
        $addPaymentView = $this->resolvePaymentView();
        $paymentView    = new $addPaymentView($orderPaymentTransaction);
        $content        = $this->renderColumnContent($paymentView->render());
        return $this->render($this->getDefaultLayout(), array('content' => $content));
    }
    
    /**
     * Get type of payment
     */
    abstract protected function getType();
    
    /**
     * @inheritdoc
     */
    protected function resolvePaymentView()
    {
        return '\common\modules\payment\views\\' . $this->getType() . '\AddPaymentView';
    }
}