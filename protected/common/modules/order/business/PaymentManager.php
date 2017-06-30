<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\order\business;

use common\modules\order\dto\PaymentFormDTO;
use common\modules\order\models\AdminSelectPaymentMethodForm;
use usni\UsniAdaptor;
use common\modules\order\models\OrderPaymentTransactionMap;
use common\modules\order\dto\PaymentGridViewDTO;
/**
 * Implements business logic for payment
 *
 * @package common\modules\order\business
 */
class PaymentManager extends \common\business\Manager
{
    use \common\modules\payment\traits\PaymentTrait;
    use \common\modules\order\traits\OrderTrait;
    
    /**
     * Process select payment
     * @param PaymentFormDTO $paymentFormDTO
     * @return void
     */
    public function processSelectPayment(PaymentFormDTO $paymentFormDTO)
    {
        $paymentMethod  = $paymentFormDTO->getOrder()->orderPaymentDetails->payment_method;
        $model          = new AdminSelectPaymentMethodForm(['scenario' => 'create']);
        if($model->load($paymentFormDTO->getPostData()))
        {
            $paymentFormDTO->setIsTransactionSuccess(true);
        }
        $model->payment_type    = $paymentMethod;
        $paymentFormDTO->setModel($model);
        $paymentMethods         = $this->getMultipleModePaymentMethodDropdown();
        $paymentFormDTO->setPaymentMethods($paymentMethods);
    }
    
    /**
     * Validate and save order payment transaction
     * @param OrderPaymentTransaction $orderPaymentTransaction
     * @param string $type Payment type
     * @return boolean
     */
    public function validateAndSaveOrderPaymentTransaction($orderPaymentTransaction, $type)
    {
        $orderPaymentTransaction->payment_status = 'Completed';
        if($orderPaymentTransaction->amount > $orderPaymentTransaction->pendingAmount)
        {
            $orderPaymentTransaction->addError('amount', UsniAdaptor::t('order', 'Paid amount can not be greater than the pending amount'));
        }
        elseif($orderPaymentTransaction->amount == 0)
        {
            $orderPaymentTransaction->addError('amount', UsniAdaptor::t('order', 'Paid amount should be greater than 0'));
        }
        elseif($orderPaymentTransaction->save())
        {
            $orderPaymentTrMap = new OrderPaymentTransactionMap(['scenario' => 'create']);
            $orderPaymentTrMap->payment_method = $type;
            $orderPaymentTrMap->order_id = $orderPaymentTransaction->order_id;
            $orderPaymentTrMap->amount = $orderPaymentTransaction->amount;
            $orderPaymentTrMap->transaction_record_id = $orderPaymentTransaction->id;
            if($orderPaymentTrMap->save())
            {
                $orderPaymentTransaction->amount = null;
                $orderPaymentTransaction->received_date = null;
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
    
    /**
     * inheritdoc
     * @param PaymentGridViewDTO $gridViewDTO
     */
    public function processList($gridViewDTO)
    {
        parent::processList($gridViewDTO);
        $paymentMethods         = $this->getPaymentMethodDropdown();
        $gridViewDTO->setPaymentMethods($paymentMethods);
    }
    
    /**
     * @inheritdoc
     */
    public function getPermissionPrefix($modelClass)
    {
        return 'order.bulk-delete';
    }
}