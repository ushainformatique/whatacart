<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\business\paypal_standard;

use common\modules\extension\models\Extension;
use usni\UsniAdaptor;
use common\modules\payment\dto\PaypalStandardFormDTO;
use common\modules\payment\models\paypal_standard\PaypalSetting;
use common\modules\payment\models\paypal_standard\PaypalOrderStatus;
use usni\library\utils\ArrayUtil;
use yii\helpers\Url;
use usni\library\utils\NumberUtil;
use common\utils\ApplicationUtil;
use common\modules\payment\dao\paypal_standard\PaypalStandardDAO;
use common\modules\payment\models\paypal_standard\PaypalStandardTransaction;
use common\modules\payment\db\paypal_standard\PaypalStandardTransactionTableBuilder;
use yii\base\Model;
use common\modules\order\models\Order;
use common\modules\order\dao\OrderDAO;
use Yii;
use common\modules\order\events\OrderEvent;
use common\modules\order\services\NotificationService;
/**
 * PaypalStandardManager class file.
 * 
 * @package common\modules\payment\business\paypal_standard
 */
class Manager extends \common\modules\payment\business\Manager
{
    use \common\modules\localization\modules\orderstatus\traits\OrderStatusTrait;
    use \common\modules\order\traits\OrderTrait;
    
    /**
     * Paypal rest urls.
     */
    const PAYPAL_PRODUCTION = 'https://www.paypal.com/cgi-bin/webscr';
    const ENDPOINT_PRODUCTION = 'https://api-3t.paypal.com/nvp';
    const PAYPAL_SANDBOX = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    const ENDPOINT_SANDBOX = 'https://api-3t.sandbox.paypal.com/nvp';
    
    /**
     * inheritdoc
     */
    public function behaviors()
    {
        return [
            NotificationService::className()
        ];
    }
    
    /**
     * Process change status.
     * @param integer $id
     * @param integer $status
     */
    public function processChangeStatus($id, $status)
    {
        $extension      = Extension::findOne($id);
        if($this->checkIfPaymentMethodAllowedToDeactivate() == false)
        {
            return false;
        }
        //Install/Uninstall PaypalStandardTransactionTableBuilder
        if($status == Extension::STATUS_ACTIVE)
        {
            //Install table
            $builderClassName = str_replace('/', '\\', PaypalStandardTransactionTableBuilder::className());
            $instance = new $builderClassName();
            $instance->buildTable();
            //Insert data
            $paypalToOrderStatusMap = $this->getPaypalToOrderStatusMap();
            $this->configManager->batchInsertStoreConfiguration($paypalToOrderStatusMap, $this->selectedStoreId, 'paypal_standard_orderstatus_map', 'payment');
        }
        elseif($status == Extension::STATUS_INACTIVE)
        {
            //Drop table
            $builderClassName = str_replace('/', '\\', PaypalStandardTransactionTableBuilder::className());
            $instance = new $builderClassName();
            $instance->dropTableIfExists($instance->getTableName());
            //Delete data
            $this->configManager->deleteStoreConfiguration('paypal_standard_orderstatus_map', 'payment');
        }
        $extension->status = $status;
        $extension->save();
        return true;
    }
    
    /**
     * Process settings.
     * @param PaypalStandardFormDTO $formDTO
     */
    public function processSettings($formDTO)
    {
        $paypalSettings     = new PaypalSetting();
        $paypalOrderStatus  = new PaypalOrderStatus();
        $postData           = $formDTO->getPostData();
        if(isset($postData['PaypalSetting']))
        {
            $paypalSettings->attributes     = $postData['PaypalSetting'];
            $paypalOrderStatus->attributes  = $postData['PaypalOrderStatus'];
            if(Model::validateMultiple([$paypalSettings, $paypalOrderStatus]))
            {
               $this->configManager->processInsertOrUpdateConfiguration($paypalSettings, 'paypal_standard', 'payment', $this->selectedStoreId);
               $this->configManager->processInsertOrUpdateConfiguration($paypalOrderStatus, 'paypal_standard_orderstatus_map', 'payment', $this->selectedStoreId);
               $formDTO->setIsTransactionSuccess(true);
            }
        }
        else
        {
            $paypalSettings->attributes     = $this->configManager->getConfigurationByCode('paypal_standard', 'payment');
            $paypalOrderStatus->attributes  = $this->configManager->getConfigurationByCode('paypal_standard_orderstatus_map', 'payment');
        }
        $formDTO->setPaypalSettings($paypalSettings);
        $formDTO->setPaypalOrderStatus($paypalOrderStatus);
        $orderStatusData = $this->getOrderStatusDropdownData();
        $formDTO->setOrderStatusDropdownData($orderStatusData);
        $formDTO->setTransactionType($this->getTransactionType());
    }
    
    /**
     * Sets variables.
     * 
     * @return void
     */
    public function getPaypalConfig()
    {
        $paypalConfig = [];
        $inputConfig  = [];
        if(UsniAdaptor::app()->installed == true)
        {
            $inputConfig            = $this->configManager->getConfigurationByCode('paypal_standard', 'payment');
            if(empty($inputConfig))
            {
                $paypalConfig['paypalSandbox']  = true;
                $paypalConfig['returnUrl']      = Url::to(['/payment/paypal_standard/default/return'], true);
                $paypalConfig['cancelUrl']      = Url::to(['/payment/paypal_standard/default/cancel'], true);
                $paypalConfig['notifyUrl']      = Url::to(['/payment/paypal_standard/default/notify'], true);
                $paypalConfig['businessEmail']  = null;
                $paypalConfig['paymentAction']  = 'authorization';
            }
            else
            {
                $paypalConfig['paypalSandbox']  = $inputConfig['sandbox'];
                $paypalConfig['returnUrl']      = Url::to([ArrayUtil::getValue($inputConfig, 'return_url')], true);
                $paypalConfig['cancelUrl']      = Url::to([ArrayUtil::getValue($inputConfig, 'cancel_url')], true);
                $paypalConfig['notifyUrl']      = Url::to([ArrayUtil::getValue($inputConfig, 'notify_url')], true);
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
     * Verify receiver email
     * @param string $inputEmail
     * @return boolean
     */
    public function verifyReceiverEmail($inputEmail)
    {
        $config = $this->getPaypalConfig();
        if($config['businessEmail'] == $inputEmail)
        {
            return true;
        }
        return false;
    }
    
    /**
     * Verify order total
     * @param Array $order
     * @param float $inputAmount
     * @return boolean
     */
    public function verifyOrderAmount($order, $inputAmount)
    {
        $total = $order['total_including_tax'] + $order['shipping_fee']; 
        Yii::info("Total amount is " . $total, 'paypal_standard');
        Yii::info("Input amount is " . $inputAmount, 'paypal_standard');
        return NumberUtil::compareFloat($inputAmount, $total);
    }
    
    /**
     * Verify order total
     * @param Array $order
     * @param float $inputCurrency
     * @return boolean
     */
    public function verifyOrderCurrency($order, $inputCurrency)
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
     * Process order update with IPN data
     * @param array $postData
     * @return void
     */
    public function processOrderUpdate($postData)
    {
        $defaultStatus  = $this->configManager->getSettingValue('order_status');
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
        $order  = OrderDAO::getById($orderId, $this->language, $this->selectedStoreId);
        if($order == null)
        {
            Yii::error('The order corresponding to order id sent in ipn response doesn\'t exist in the system', 'paypal_standard');
            return;
        }
        //if transaction id is missing in post simply insert the order history. In case of authorization, this would be the case.
        if($transactionId == null)
        {
            Yii::info('Transaction id sent in the ipn response from paypal is null', 'paypal_standard');
            $this->saveOrderHistory($order, UsniAdaptor::t('paypal', 'Ipn response from paypal with no transaction id and status {status}', ['status' => $paymentStatus]), false);
            return;
        }
        $dbTransaction  = UsniAdaptor::app()->db->beginTransaction();
        try
        {
            $status         = $this->getSystemOrderStatusByPaypalStatus($paymentStatus);
            Yii::info("System status corresponding to " . $paymentStatus . " is $status", 'paypal_standard');
            if($paymentStatus === 'Completed')
            {
                $isVerified = $this->validateResponse($order, $postData);
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
                $orderPaymentTransaction = $this->savePaypalTransaction($postData);
                if($orderPaymentTransaction !== false)
                {
                    Yii::info('After saving paypal transaction', 'paypal_standard');
                    //Save payment transaction map.
                    $isSuccess = $this->saveOrderPaymentTransactionMap($orderPaymentTransaction, $postData['mc_gross'], $postData['custom'], 'paypal_standard');
                }
                if($isSuccess)
                {
                    Yii::info('Transaction is successfull with success verification', 'paypal_standard');
                    $dbTransaction->commit();
                    $order  = OrderDAO::getById($orderId, $this->language, $this->selectedStoreId);
                    $this->saveOrderHistory($order, UsniAdaptor::t('paypal', 'Ipn response from paypal with status {status}', ['status' => $paymentStatus]), true);
                    if($paymentStatus == "Completed")
                    {
                        $this->trigger(Order::EVENT_ORDER_COMPLETED, new OrderEvent(['order' => $order]));
                    }
                    else
                    {
                        $this->trigger(Order::EVENT_NEW_ORDER_CREATED, new OrderEvent(['order' => $order]));
                    }
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
                $order  = OrderDAO::getById($orderId, $this->language, $this->selectedStoreId);
                $this->saveOrderHistory($order, UsniAdaptor::t('paypal', 'Ipn failed verification with paypal with status {status}', ['status' => $paymentStatus]), false);
            }
        }
        catch(Exception $e)
        {
            $dbTransaction->rollBack();
            Yii::error('Paypal payment transaction fails with error ' . $e->getMessage(), 'paypal_standard');
        }
    }
    
    /**
     * Validate response on completed status
     * @param array $order
     * @param array $postData
     * @return boolean
     */
    public function validateResponse($order, $postData)
    {
        $isVerified         = true;
        $verifyEmail        = $this->verifyReceiverEmail($postData['receiver_email']);
        $verifyAmount       = $this->verifyOrderAmount($order, $postData['mc_gross']);
        $verifyCurrency     = $this->verifyOrderCurrency($order, $postData['mc_currency']);
        $verifyTransaction  = $this->verifyCompletedTransactionId($postData["txn_id"]);
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
     * Verify completed transaction id.
     * @param string $inputTransactionId
     * @return boolean
     */
    public function verifyCompletedTransactionId($inputTransactionId)
    {
        $cnt = PaypalStandardDAO::getCountByTransactionId($inputTransactionId);
        if($cnt == 0)
        {
            return true;
        }
        return false;
    }
    
    /**
     * Save paypal transaction
     * @param array $postData
     * @return boolean
     */
    public function savePaypalTransaction($postData)
    {
        $transactionFee     = ArrayUtil::getValue($postData, 'mc_fee', 0);
        $isTransactionThere = $this->doesTransactionIdExist($postData['txn_id'], PaypalStandardTransaction::tableName());
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
     * @inheritdoc
     */
    public static function getLogCategory()
    {
        return 'paypal_standard';
    }
    
    /**
     * Get transaction table builder class name
     * @return string
     */
    public function getTransactionTableBuilderClassName()
    {
        return PaypalStandardTransactionTableBuilder::className();
    }
    
    /**
     * Get transaction model class name
     * @return string
     */
    public function getTransactionModelClassName()
    {
        return PaypalStandardTransaction::className();
    }
    
    /**
     * Paypal to order status map.
     * @return array
     */
    public function getPaypalToOrderStatusMap()
    {
        $allOrderStatus = $this->getAllOrderStatus();
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
     * Get system order status by paypal status.
     * @param string $paymentStatus
     * @param string $code
     * @return integer
     */
    public function getSystemOrderStatusByPaypalStatus($paymentStatus, $code = 'paypal_standard_orderstatus_map')
    {
        $status                 = null;
        switch($paymentStatus)
        {
            case 'Canceled_Reversal':
                 $status = $this->configManager->getStoreValueByKey('canceled_reversal_status', $code, 'payment');
                 break;
            case 'Completed':
                $status = $this->configManager->getStoreValueByKey('completed_status', $code, 'payment');
                break;
            case 'Denied':
                $status = $this->configManager->getStoreValueByKey('denied_status', $code, 'payment');
                break;
            case 'Expired':
                $status = $this->configManager->getStoreValueByKey('expired_status', $code, 'payment');
                break;
            case 'Failed':
                $status = $this->configManager->getStoreValueByKey('failed_status', $code, 'payment');
                break;
            case 'Pending':
                $status = $this->configManager->getStoreValueByKey('pending_status', $code, 'payment');
                break;
            case 'Processed':
                $status = $this->configManager->getStoreValueByKey('processed_status', $code, 'payment');
                break;
            case 'Refunded':
                $status = $this->configManager->getStoreValueByKey('refunded_status', $code, 'payment');
                break;
            case 'Reversed':
                $status = $this->configManager->getStoreValueByKey('reversed_status', $code, 'payment');
                break;
            case 'Voided':
                $status = $this->configManager->getStoreValueByKey('voided_status', $code, 'payment');
                break;
        }
        if($status != null)
        {
            return $status;
        }
        return $this->configManager->getSettingValue('order_status', $this->selectedStoreId);
     }
     
    /**
     * Get transaction type
     * @return array
     */
    public function getTransactionType()
    {
        return [
            'authorization' => UsniAdaptor::t('paypal', 'Authorization'),
            'sale' => UsniAdaptor::t('paypal', 'Sale')
        ];
    }
}
