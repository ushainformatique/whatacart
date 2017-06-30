<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\utils;

use usni\UsniAdaptor;
use common\modules\extension\models\Extension;
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
     * Get transaction attribute labels
     * @return array
     */
    public static function getTransactionAttributeLabels()
    {
        return [
                        'transaction_id'    => UsniAdaptor::t('payment', 'Transaction ID'),
                        'transaction_fee'   => UsniAdaptor::t('payment', 'Transaction Fee'),
                        'amount'            => UsniAdaptor::t('payment', 'Amount'),
                        'payment_status'    => UsniAdaptor::t('payment', 'Payment Status'),
                        'order_id'          => UsniAdaptor::t('payment', 'Order'),
                        'totalAmount'      => UsniAdaptor::t('payment', 'Total Amount'),
                        'alreadyPaidAmount'=> UsniAdaptor::t('payment', 'Captured Amount'),
                        'pendingAmount'    => UsniAdaptor::t('payment', 'Pending Amount'),
                        'received_date'    => UsniAdaptor::t('payment', 'Received Date'),
                  ];
    }
}