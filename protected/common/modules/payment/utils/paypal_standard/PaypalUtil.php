<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\payment\utils\paypal_standard;

use usni\UsniAdaptor;
use yii\helpers\Url;
use products\utils\ProductUtil;
use common\modules\stores\utils\StoreUtil;
use Yii;
use usni\library\utils\NumberUtil;
use common\modules\order\models\Order;
use common\modules\localization\modules\orderstatus\utils\OrderStatusUtil;
use usni\library\utils\ArrayUtil;
use common\utils\ApplicationUtil;
use common\modules\order\utils\OrderUtil;
use common\modules\payment\models\paypal_standard\PaypalStandardTransaction;
use common\modules\order\models\OrderPaymentTransactionMap;
/**
 * Contains utility functions related to paypal
 * 
 * @package common\modules\payment\utils\paypal_standard
 */
class PaypalUtil
{
    /**
     * Paypal rest urls.
     */
    const PAYPAL_PRODUCTION = 'https://www.paypal.com/cgi-bin/webscr';
    const ENDPOINT_PRODUCTION = 'https://api-3t.paypal.com/nvp';
    const PAYPAL_SANDBOX = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    const ENDPOINT_SANDBOX = 'https://api-3t.sandbox.paypal.com/nvp';
    
    /**
     * Set paypal form variables to be posted with request
     * @param $cartDetails Cart Details
     * @param $checkoutDetails Checkout Details
     * @see https://developer.paypal.com/docs/classic/paypal-payments-standard/integration-guide/formbasics/
     * @see http://stackoverflow.com/questions/3308898/paying-for-multiple-items-at-once-via-paypal
     * @see https://www.paypal.com/cgi-bin/webscr?cmd=_pdn_howto_checkout_outside#methodtwo
     */
    public static function setFormVariables($cartDetails, $checkoutDetails, $paypalManager)
    {
        $order          = $checkoutDetails->order;
        $index          = 1;
        foreach($cartDetails->itemsList as $product => $data)
        {
            $name = $data['name'];
            if($data['selectedOptions'] != null)
            {
                $name .= '<br/>' . $data['selectedOptions']; 
            }
            $paypalManager->addField('item_name_' . $index, $name);
            $priceByCurrency        = ProductUtil::getPriceByCurrency($data['price']);
            $paypalManager->addField('amount_' . $index, $priceByCurrency);
            $paypalManager->addField('item_number_' . $index, $data['product_id']);
            $paypalManager->addField('quantity_' . $index, $data['qty']);
            $paypalManager->addField('tax_' . $index, ProductUtil::getPriceByCurrency($data['tax']));
            $index++;
        }
        if($order->shipping_fee > 0)
        {
            //Shipping
            $paypalManager->addField('item_name_' . $index, UsniAdaptor::t('shipping', 'Shipping'));
            $shippingPriceByCurrency        = $order->shipping_fee;
            $paypalManager->addField('amount_' . $index, $shippingPriceByCurrency);
            $paypalManager->addField('item_number_' . $index, $index);
            $paypalManager->addField('quantity_' . $index, 1);
        }
        //Billing details
        $paypalManager->addField('first_name', $checkoutDetails->billingInfoEditForm->firstname);
        $paypalManager->addField('last_name', $checkoutDetails->billingInfoEditForm->lastname);
        $paypalManager->addField('email', $checkoutDetails->billingInfoEditForm->email);
        $paypalManager->addField('custom', $order->id);
        $paypalManager->addField('upload', "1");
        $paypalManager->addField('cmd', '_cart');
        $paypalManager->addField('address_override', "0");
    }
    
    /**
     * Sets variables.
     * 
     * @return void
     */
    public static function getPaypalConfig()
    {
        $currency     = UsniAdaptor::app()->currencyManager->getDisplayCurrency();
        $paypalConfig = [];
        $inputConfig  = [];
        if(UsniAdaptor::app()->installed == true)
        {
            $inputConfig = StoreUtil::getStoreConfgurationAttributesByCodeForStore('paypal_standard', 'payment');
            if(empty($inputConfig))
            {
                $paypalConfig['paypalSandbox']  = true;
                $paypalConfig['currency']       = $currency;
                $paypalConfig['returnUrl']     = Url::to(['/payment/paypal_standard/default/return'], true);
                $paypalConfig['cancelUrl']     = Url::to(['/payment/paypal_standard/default/cancel'], true);
                $paypalConfig['notifyUrl']     = Url::to(['/payment/paypal_standard/default/notify'], true);
                $paypalConfig['businessEmail'] = null;
                $paypalConfig['paymentAction'] = 'authorization';
            }
            else
            {
                $paypalConfig['paypalSandbox']  = $inputConfig['sandbox'];
                $paypalConfig['currency']       = $currency;
                $paypalConfig['returnUrl']      = Url::to([$inputConfig['return_url']], true);
                $paypalConfig['cancelUrl']      = Url::to([$inputConfig['cancel_url']], true);
                $paypalConfig['notifyUrl']      = Url::to([$inputConfig['notify_url']], true);
                $paypalConfig['businessEmail']  = $inputConfig['business_email'];
                $paypalConfig['paymentAction']  = ArrayUtil::getValue($inputConfig, 'transactionType', 'authorization');
            }
            if((bool)$paypalConfig['paypalSandbox'] === false)
            {
                $paypalConfig['paypalUrl']  = self::PAYPAL_PRODUCTION;
                $paypalConfig['endPoint']   = self::ENDPOINT_PRODUCTION;
            }
            else
            {
                $paypalConfig['paypalUrl']  = self::PAYPAL_SANDBOX;
                $paypalConfig['endPoint']   = self::ENDPOINT_SANDBOX;
            }
            return $paypalConfig;
        }
    }
    
    /**
     * Get system order status by paypal status.
     * @param string $paymentStatus
     * @return integer
     */
    public static function getSystemOrderStatusByPaypalStatus($paymentStatus)
    {
        $status = null;
        switch($paymentStatus)
        {
            case 'Canceled_Reversal':
                    $status = StoreUtil::getStoreValueByKey('canceled_reversal_status', 'paypal_standard_orderstatus_map', 'payment');
                    break;
            case 'Completed':
                $status = StoreUtil::getStoreValueByKey('completed_status', 'paypal_standard_orderstatus_map', 'payment');
                break;
            case 'Denied':
                $status = StoreUtil::getStoreValueByKey('denied_status', 'paypal_standard_orderstatus_map', 'payment');
                break;
            case 'Expired':
                $status = StoreUtil::getStoreValueByKey('expired_status', 'paypal_standard_orderstatus_map', 'payment');
                break;
            case 'Failed':
                $status = StoreUtil::getStoreValueByKey('failed_status', 'paypal_standard_orderstatus_map', 'payment');
                break;
            case 'Pending':
                $status = StoreUtil::getStoreValueByKey('pending_status', 'paypal_standard_orderstatus_map', 'payment');
                break;
            case 'Processed':
                $status = StoreUtil::getStoreValueByKey('processed_status', 'paypal_standard_orderstatus_map', 'payment');
                break;
            case 'Refunded':
                $status = StoreUtil::getStoreValueByKey('refunded_status', 'paypal_standard_orderstatus_map', 'payment');
                break;
            case 'Reversed':
                $status = StoreUtil::getStoreValueByKey('reversed_status', 'paypal_standard_orderstatus_map', 'payment');
                break;
            case 'Voided':
                $status = StoreUtil::getStoreValueByKey('voided_status', 'paypal_standard_orderstatus_map', 'payment');
                break;
        }
        if($status != null)
        {
            return $status;
        }
        return StoreUtil::getSettingValue('order_status');
     }
     
    /**
     * Verify receiver email
     * @param string $inputEmail
     * @return boolean
     */
    public static function verifyReceiverEmail($inputEmail)
    {
        $config = PaypalUtil::getPaypalConfig();
        if($config['businessEmail'] == $inputEmail)
        {
            return true;
        }
        return false;
    }
    
    /**
     * Verify order total
     * @param float $inputAmount
     * @param Array $order
     * @return boolean
     */
    public static function verifyOrderAmount($order, $inputAmount)
    {
        $total = $order['total_including_tax'] + $order['shipping_fee']; 
        Yii::info("Total amount is " . $total, 'paypal_standard');
        Yii::info("Input amount is " . $inputAmount, 'paypal_standard');
        return NumberUtil::compareFloat($inputAmount, $total);
    }
    
    /**
     * Verify order total
     * @param float $inputCurrency
     * @param Array $order
     * @return boolean
     */
    public static function verifyOrderCurrency($order, $inputCurrency)
    {
        Yii::info("Order currency is " . $order['currency_code'], 'paypal_standard');
        Yii::info("Input currency is " . $inputCurrency, 'paypal_standard');
        if($order['currency_code'] == $inputCurrency)
        {
            return true;
        }
        return false;
    }
    
    /**
     * Verify completed transaction id
     * @param string $inputTransactionId
     * @param string $table
     * @return boolean
     */
    public static function verifyCompletedTransactionId($inputTransactionId)
    {
        $table      = UsniAdaptor::tablePrefix() . 'paypal_standard_transaction';
        $sql        = "SELECT COUNT(*) AS cnt 
                      FROM $table 
                      WHERE transaction_id = :tid AND payment_status = :status";
        $connection         = UsniAdaptor::app()->getDb();
        $cnt        = $connection->createCommand($sql, [':tid' => $inputTransactionId, ':status' => 'Completed'])->queryScalar();
        if($cnt == 0)
        {
            return true;
        }
        return false;
    }
    
    /**
     * Paypal to order status map.
     * @return array
     */
    public static function getPaypalToOrderStatusMap()
    {
        $allOrderStatus = OrderStatusUtil::getAllOrderStatus();
        return  [
                    'canceled_reversal_status'  => $allOrderStatus[Order::STATUS_CANCELLED_REVERSAL],
                    'completed_status'          => $allOrderStatus[Order::STATUS_COMPLETED],
                    'denied_status'             => $allOrderStatus[Order::STATUS_DENIED],
                    'expired_status'            => $allOrderStatus[Order::STATUS_EXPIRED],
                    'failed_status'             => $allOrderStatus[Order::STATUS_FAILED],
                    'pending_status'            => $allOrderStatus[Order::STATUS_PENDING],
                    'processed_status'          => $allOrderStatus[Order::STATUS_PROCESSED],
                    'refunded_status'           => $allOrderStatus[Order::STATUS_REFUNDED],
                    'reversed_status'           => $allOrderStatus[Order::STATUS_REVERSED],
                    'voided_status'             => $allOrderStatus[Order::STATUS_VOIDED]
                ];
    }
    
    /**
     * Get transaction type
     * @return array
     */
    public static function getTransactionType()
    {
        return [
            'authorization' => UsniAdaptor::t('paypal', 'Authorization'),
            'sale' => UsniAdaptor::t('paypal', 'Sale')
        ];
    }
    
    /**
     * Process order update
     * @param array $postData
     * @return void
     */
    public static function processOrderUpdate($postData)
    {
        $defaultStatus  = StoreUtil::getSettingValue('order_status');
        $userId         = ApplicationUtil::getCustomerId();
        $orderTable     = UsniAdaptor::tablePrefix(). 'order';
        $isSuccess      = false; //Whether we need to commit
        $isVerified     = true;
        $orderId        = ArrayUtil::getValue($postData, 'custom', null);
        $paymentStatus  = ArrayUtil::getValue($postData, 'payment_status', null);
        $transactionId  = ArrayUtil::getValue($postData, 'txn_id', null);
        
        //If order id is null
        if($orderId == null)
        {
            Yii::error('Order id sent in the ipn response from paypal is null', 'paypal_standard');
            return;
        }
        
        $order          = OrderUtil::getOrder($orderId);
        if($order === false)
        {
            Yii::error('The order corresponding to order id sent in ipn response doesn\'t exist in the system', 'paypal_standard');
            return;
        }
        
        //if transaction id is missing in post simply insert the order history. In case of authorization, this would be the case.
        if($transactionId == null)
        {
            Yii::info('Transaction id sent in the ipn response from paypal is null', 'paypal_standard');
            PaypalUtil::saveOrderHistory($order, UsniAdaptor::t('paypal', 'Ipn response from paypal with no transaction id and status {status}', ['status' => $paymentStatus]));
            return;
        }
        $dbTransaction  = UsniAdaptor::app()->db->beginTransaction();
        try
        {
            $status         = PaypalUtil::getSystemOrderStatusByPaypalStatus($paymentStatus);
            Yii::info("System status corresponding to " . $paymentStatus . " is $status", 'paypal_standard');
            if($paymentStatus === 'Completed')
            {
                $isVerified = self::validateResponse($order, $postData);
                if(!$isVerified)
                {
                    $status = $defaultStatus;
                }
            }
            if($isVerified)
            {
                Yii::info("Verficiation successfull", 'paypal_standard');

                //Update order
                UsniAdaptor::db()->createCommand()->update($orderTable, 
                                                    [
                                                        'status' => $status, 
                                                        'modified_by' => $userId,
                                                        'modified_datetime'  => UsniAdaptor::getNow()
                                                    ], 
                                                    'id = :id', 
                                                    [':id' => $orderId])->execute();
                //Save paypal transaction
                $orderPaymentTransaction = self::savePaypalTransaction($postData);
                if($orderPaymentTransaction !== false)
                {
                    Yii::info('After saving paypal transaction', 'paypal_standard');
                    //Save payment transaction map.
                    $isSuccess = self::saveOrderPaymentTransactionMap($orderPaymentTransaction, $postData);
                }
                if($isSuccess)
                {
                    Yii::info('Transaction is successfull with success verification', 'paypal_standard');
                    $dbTransaction->commit();
                    $order      = OrderUtil::getOrder($orderId);
                    static::saveOrderHistory($order, UsniAdaptor::t('paypal', 'Ipn response from paypal with status {status}', ['status' => $paymentStatus]));
                }
                else
                {
                    Yii::error('Transaction fails with success verification', 'paypal_standard');
                    $dbTransaction->rollBack();
                }
            }
            else
            {
                Yii::error('Transaction is successfull with failed verification', 'paypal_standard');
                //Update order
                UsniAdaptor::db()->createCommand()->update($orderTable, 
                                                    [
                                                        'status' => $status, 
                                                        'modified_by' => $userId,
                                                        'modified_datetime'  => UsniAdaptor::getNow()
                                                    ], 
                                                    'id = :id', 
                                                    [':id' => $orderId])->execute();
                $dbTransaction->commit();
                $order          = OrderUtil::getOrder($orderId);
                static::saveOrderHistory($order, UsniAdaptor::t('paypal', 'Ipn failed verification with paypal with status {status}', ['status' => $paymentStatus]));
            }
        }
        catch(Exception $e)
        {
            $dbTransaction->rollBack();
            Yii::error('Paypal payment transaction fails with error ' . $e->getMessage(), 'paypal_standard');
        }
    }
    
    /**
     * Save order history
     * @param Order $order
     * @param string $message
     */
    public static function saveOrderHistory($order, $message)
    {
        $attributes = [
                'order_id' => $order['id'], 
                'status'   => $order['status'],
                'comment'  => $message,
                'notify_customer' => true
              ];
        OrderUtil::addOrderHistory($order, $attributes);
    }
    
    /**
     * Validate response on completed status
     * @param array $order
     * @param array $postData
     * @return boolean
     */
    public static function validateResponse($order, $postData)
    {
        $isVerified         = true;
        $verifyEmail        = PaypalUtil::verifyReceiverEmail($postData['receiver_email']);
        $verifyAmount       = PaypalUtil::verifyOrderAmount($order, $postData['mc_gross']);
        $verifyCurrency     = PaypalUtil::verifyOrderCurrency($order, $postData['mc_currency']);
        $verifyTransaction  = PaypalUtil::verifyCompletedTransactionId($postData["txn_id"]);
        if(!$verifyEmail)
        {
            $isVerified = false;
            Yii::error('Paypal standard email verification fails', 'paypal_standard');
        }
        if(!$verifyAmount)
        {
            $isVerified = false;
            Yii::error('Paypal standard amount verification fails', 'paypal_standard');
        }
        if(!$verifyTransaction)
        {
            $isVerified = false;
            Yii::error('Paypal standard transaction verification fails', 'paypal_standard');
        }
        if(!$verifyCurrency)
        {
            $isVerified = false;
            Yii::error('Paypal standard currency verification fails', 'paypal_standard');
        }
        return $isVerified;
    }
    
    /**
     * Save paypal transaction
     * @param array $postData
     * @return boolean
     */
    public static function savePaypalTransaction($postData)
    {
        $transactionFee = ArrayUtil::getValue($postData, 'mc_fee', 0);
        $isTransactionThere = OrderUtil::doesTransactionIdExist($postData['txn_id'], PaypalStandardTransaction::tableName());
        if($isTransactionThere)
        {
            Yii::info("Transaction id exist", 'paypal_standard');
            $orderPaymentTransaction = PaypalStandardTransaction::find()->where('transaction_id = :tid', [':tid' => $postData['txn_id']])->one();
            $orderPaymentTransaction->scenario = 'update';
        }
        else
        {
            Yii::info("Transaction id does not exist", 'paypal_standard');
            //Save transaction
            $orderPaymentTransaction = new PaypalStandardTransaction(['scenario' => 'create']);
        }
        $orderPaymentTransaction->payment_status    = $postData['payment_status'];
        $orderPaymentTransaction->transaction_id    = $postData['txn_id'];
        $orderPaymentTransaction->transaction_fee   = $transactionFee;
        $orderPaymentTransaction->amount            = $postData['mc_gross'];
        $orderPaymentTransaction->received_date     = date('Y-m-d');
        $orderPaymentTransaction->order_id          = $postData['custom'];
        if($orderPaymentTransaction->save())
        {
            return $orderPaymentTransaction;
        }
        return false;
    }
    
    /**
     * Save order payment transaction map
     * @param OrderPaymentTransaction $orderPaymentTransaction
     * @param array $postData
     * @return boolean
     */
    public static function saveOrderPaymentTransactionMap($orderPaymentTransaction, $postData)
    {
        $orderPaymentTrMap = OrderPaymentTransactionMap::find()
                                ->where('order_id = :oid AND transaction_record_id = :tid', 
                                [':tid' => $orderPaymentTransaction->id, ':oid' => $postData['custom']])
                                ->asArray()
                                ->one();
        if(empty($orderPaymentTrMap))
        {
            Yii::info("Order payment tr map doesn't exist", 'paypal_standard');
            //Save map
            $orderPaymentTrMap = new OrderPaymentTransactionMap(['scenario' => 'create']);
            $orderPaymentTrMap->payment_method = 'paypal_standard';
            $orderPaymentTrMap->order_id = $postData['custom'];
            $orderPaymentTrMap->amount = $postData['mc_gross'];
            $orderPaymentTrMap->transaction_record_id = $orderPaymentTransaction->id;
            if($orderPaymentTrMap->save())
            {
                Yii::info("Order payment tr map save is successfull", 'paypal_standard');
                return true;
            }
        }
        else
        {
            Yii::info("Order payment tr map record exist", 'paypal_standard');
            return true;
        }
        Yii::error("Order payment tr map save fails", 'paypal_standard');
        return false;
    }
}