<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\db\paypal_standard;

use usni\library\db\TableBuilder;
use usni\UsniAdaptor;
/**
 * PaypalStandardTransactionTableBuilder class file.
 *
 * @package common\modules\payment\db\paypal_standard
 */
class PaypalStandardTransactionTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => $this->primaryKey(11)->notNull(),
            'order_id' => $this->integer(11)->notNull(),
            'payment_status'  => $this->string(32)->notNull(),
            'received_date'   => $this->date()->notNull(),
            'transaction_id'  => $this->string(32)->notNull(),
            'transaction_fee' => $this->decimal(10,2)->notNull()->defaultValue(0),
            'amount'          => $this->decimal(10,2)->notNull()->defaultValue(0),
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_payment_status', 'payment_status', false],
                    ['idx_transaction_id', 'transaction_id', false],
                    ['idx_order_id', 'order_id', false]
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getForeignKeys()
    {
        $orderTableName         = UsniAdaptor::tablePrefix() . 'order';
        $transactionTableName   = UsniAdaptor::tablePrefix() . 'paypal_standard_transaction';
        return [
                  ['fk_' . $transactionTableName . '_order_id', $transactionTableName, 'order_id', $orderTableName, 'id', 'CASCADE', 'NO ACTION']
               ];
    }
}