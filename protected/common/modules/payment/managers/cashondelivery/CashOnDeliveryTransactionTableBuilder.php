<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\managers\cashondelivery;

use usni\library\components\UiTableBuilder;
use common\modules\payment\models\cashondelivery\CashOnDeliveryTransaction;
/**
 * CashOnDeliveryTransactionTableBuilder class file.
 *
 * @package common\modules\payment\managers\cashondelivery
 */
class CashOnDeliveryTransactionTableBuilder extends UiTableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => $this->primaryKey(11)->notNull(),
            'order_id' => $this->integer(11)->notNull(),
            'payment_status'  => $this->string(16)->notNull(),
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
    public function getTableName()
    {
        return CashOnDeliveryTransaction::tableName();
    }
}