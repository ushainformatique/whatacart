<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\dao\paypal_standard;

use usni\UsniAdaptor;
/**
 * Implements data access functionality related to paypal standard.
 *
 * @package common\modules\payment\dao\paypal_standard
 */
class PaypalStandardDAO
{
    /**
     * Get count by transaction id.
     * @param string $inputTransactionId
     * @return integer
     */
    public static function getCountByTransactionId($inputTransactionId)
    {
        $table      = UsniAdaptor::tablePrefix() . 'paypal_standard_transaction';
        $sql        = "SELECT COUNT(*) AS cnt 
                      FROM $table 
                      WHERE transaction_id = :tid AND payment_status = :status";
        $connection = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':tid' => $inputTransactionId, ':status' => 'Completed'])->queryScalar();
    }
}
