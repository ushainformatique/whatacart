<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\db;

use usni\library\db\TableBuilder;
use usni\UsniAdaptor;
/**
 * OrderPaymentTransactionMapTableBuilder class file.
 *
 * @package common\modules\order\db
 */
class OrderPaymentTransactionMapTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id'            => $this->primaryKey(11),
            'order_id'      => $this->integer(11)->notNull(),
            'amount'        => $this->decimal(10,2)->notNull()->defaultValue(0),
            'payment_method'=> $this->string(20)->notNull(),
            'transaction_record_id' => $this->integer(11)->notNull()
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_order_id', 'order_id', false],
                    ['idx_amount', 'amount', false],
                    ['idx_payment_method', 'payment_method', false],
                    ['idx_transaction_record_id', 'transaction_record_id', false],
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getForeignKeys()
    {
        $orderTableName         = UsniAdaptor::tablePrefix() . 'order';
        $paymentTrMapTableName  = UsniAdaptor::tablePrefix() . 'order_payment_transaction_map';
        return [
                  ['fk_' . $paymentTrMapTableName . '_order_id', $paymentTrMapTableName, 'order_id', $orderTableName, 'id', 'CASCADE', 'NO ACTION']
               ];
    }
}