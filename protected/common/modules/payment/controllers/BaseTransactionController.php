<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\payment\controllers;

use usni\UsniAdaptor;
use usni\library\utils\FlashUtil;
use common\modules\order\dao\OrderDAO;
use common\modules\order\business\PaymentManager;
use common\modules\order\business\Manager as OrderBusinessManager;
use common\modules\payment\dto\TransactionFormDTO;
/**
 * BaseTransactionController class file
 * 
 * @package common\modules\payment\controllers
 */
abstract class BaseTransactionController extends \usni\library\web\Controller
{
    use \common\modules\order\traits\OrderTrait;
    
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
        $order                              = OrderDAO::getById($orderId, 
                                                                UsniAdaptor::app()->languageManager->selectedLanguage,
                                                                UsniAdaptor::app()->storeManager->selectedStoreId);
        $postData           = UsniAdaptor::app()->request->post();
        if($orderPaymentTransaction->load($postData))
        {
            $transaction    = UsniAdaptor::app()->db->beginTransaction();
            $isValid        = PaymentManager::getInstance()->validateAndSaveOrderPaymentTransaction($orderPaymentTransaction, $this->getType());
            if($isValid)
            {
                $transaction->commit();
                $orderPaymentTransaction->transaction_id    = null;
                $orderPaymentTransaction->transaction_fee   = 0;
                FlashUtil::setMessage('success', UsniAdaptor::t('order', 'The transaction is saved successfully'));
            }
        }
        $this->populatePaymentDataInOrderTransaction($orderPaymentTransaction, $order);
        $formDTO = new TransactionFormDTO();
        $formDTO->setModel($orderPaymentTransaction);
        $formDTO->setOrder($order);
        $this->populateDTOByType($formDTO);
        return $this->render($this->resolvePaymentView(), ['formDTO' => $formDTO]);
    }
    
    /**
     * Populate form dto by type 
     * @param TransactionFormDTO $formDTO
     */
    public function populateDTOByType($formDTO)
    {
        
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
        return '/' . $this->getType(). '/addpayment';
    }
    
    /**
     * Get total amount
     * @param array $order
     * @return float
     */
    protected function getTotalAmount($order)
    {
        return $order['total_including_tax'] + $order['shipping_fee'];
    }
    
    /**
     * Get paid amount
     * @param array $order
     * @return float
     */
    protected function getPaidAmount($order)
    {
        return OrderBusinessManager::getInstance()->getAlreadyPaidAmountForOrder($order['id']);;
    }
    
    /**
     * Populate payment data transaction
     * @param Model $orderPaymentTransaction
     * @param array $order
     * @return void
     */
    protected function populatePaymentDataInOrderTransaction($orderPaymentTransaction, $order)
    {
        $orderPaymentTransaction->totalAmount       = $this->getTotalAmount($order);
        $orderPaymentTransaction->alreadyPaidAmount = $this->getPaidAmount($order);
        $orderPaymentTransaction->pendingAmount     = $orderPaymentTransaction->totalAmount - $orderPaymentTransaction->alreadyPaidAmount;
    }
}