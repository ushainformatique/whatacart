<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\utils;

use usni\UsniAdaptor;
use common\modules\order\models\OrderPaymentTransactionMap;
use common\modules\extension\models\Extension;
use common\modules\extension\models\ExtensionTranslated;
use usni\library\utils\ArrayUtil;
use yii\caching\DbDependency;
/**
 * PaymentUtil class file.
 * 
 * @package common\modules\payment\utils
 */
class PaymentUtil
{
    /**
     * Gets status dropdown.
     * @return array
     */
    public static function getStatusDropdown()
    {
        return array(
            Extension::STATUS_ACTIVE     => UsniAdaptor::t('application','Active'),
            Extension::STATUS_INACTIVE   => UsniAdaptor::t('application','Inactive')
        );
    }
    
    /**
     * Validate and save order payment transaction
     * @param OrderPaymentTransaction $orderPaymentTransaction
     * @param string $type Payment type
     * @return boolean
     */
    public static function validateAndSaveOrderPaymentTransaction($orderPaymentTransaction, $type)
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
     * Get transaction attribute labels
     * @return array
     */
    public static function getTransactionAttributeLabels()
    {
        return [
                        'transaction_id'    => UsniAdaptor::t('order', 'Transaction ID'),
                        'transaction_fee'   => UsniAdaptor::t('order', 'Transaction Fee'),
                        'amount'            => UsniAdaptor::t('order', 'Amount'),
                        'payment_status'    => UsniAdaptor::t('order', 'Payment Status'),
                        'order_id'          => UsniAdaptor::t('order', 'Order'),
                        'totalAmount'      => UsniAdaptor::t('order', 'Total Amount'),
                        'alreadyPaidAmount'=> UsniAdaptor::t('order', 'Already Paid Amount'),
                        'pendingAmount'    => UsniAdaptor::t('order', 'Pending Amount'),
                        'received_date'    => UsniAdaptor::t('order', 'Received Date'),
                  ];
    }
    
    /**
     * Get payment method dropdown.
     * @return array
     */
    public static function getPaymentMethodDropdown()
    {
        $language               = UsniAdaptor::app()->languageManager->getContentLanguage();
        $extensionTable         = Extension::tableName();
        $extensionTrTable       = ExtensionTranslated::tableName();
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $extensionTable"]);
        $sql                    = "SELECT et.*, ett.name 
                                   FROM $extensionTable et, $extensionTrTable ett 
                                   WHERE et.category = :cat AND et.status = :status AND et.id = ett.owner_id AND ett.language = :lan";
        $params                 = [':status' => Extension::STATUS_ACTIVE, ':lan' => $language, ':cat' => 'payment'];
        $connection             = UsniAdaptor::app()->getDb();
        $models = $connection->createCommand($sql, $params)->cache(0, $dependency)->queryAll();
        return ArrayUtil::map($models, 'code', 'name');
    }
    
    /**
     * Get payment method name.
     * @param $type string
     * @return string
     */
    public static function getPaymentMethodName($type)
    {
        $data = self::getPaymentMethodDropdown();
        return $data[$type];
    }
}