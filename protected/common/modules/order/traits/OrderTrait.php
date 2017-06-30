<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license http://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\order\traits;

use common\modules\order\models\OrderHistory;
use common\modules\order\models\Order;
use common\modules\order\dao\OrderDAO;
/**
 * Implement common functions related to order
 *
 * @package common\modules\order\traits
 */
trait OrderTrait
{
    /**
     * Save order history
     * @param Array|Order $order
     * @param string $comment
     * @param boolean $notifyCustomer
     */
    public function saveOrderHistory($order, $comment, $notifyCustomer = true)
    {
        //Save order history
        $orderHistory = new OrderHistory(['scenario' => 'create']);
        $orderHistory->attributes = [
                                        'order_id' => $order['id'], 
                                        'status'   => $order['status'],
                                        'comment'  => $comment,
                                        'notify_customer' => $notifyCustomer
                                      ];
        if($orderHistory->save())
        {
            $orderHistory->saveTranslatedModels();
        }
    }
    
    /**
     * Get unique transaction id
     * @param string $table
     * @return boolean
     */
    public function getUniqueTransactionId($table)
    {
        $transactionId = null;
        while (true)
        {
            $rawTransactionId   = self::generateUniqueTransactionId(17);
            $transactionId      = $rawTransactionId;
            if(!$this->doesTransactionIdExist($transactionId, $table))
            {
                break;
            }
        }
        return $transactionId;
    }
    
    /**
     * Generate 17 digit unique transaction id.
     * @param integer $digitsNeeded
     * @return string
     */
    public static function generateUniqueTransactionId($digitsNeeded)
    {
        $randomNumber='';
        $count=0;
        while ( $count < $digitsNeeded ) 
        {
            $randomDigit = mt_rand(0, 9);

            $randomNumber .= $randomDigit;
            $count++;
        }
        return $randomNumber;
    }
    
    /**
     * Check if transaction id exist
     * @param string $inputTransactionId
     * @param string $table
     * @return boolean
     */
    public function doesTransactionIdExist($inputTransactionId, $table)
    {
        $cnt        = OrderDAO::getCountByTransactionId($table, $inputTransactionId);
        if($cnt == 0)
        {
            return false;
        }
        return true;
    }
}
