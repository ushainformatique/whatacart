<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\db;

use usni\library\db\TableBuilder;
use yii\db\Schema;
use usni\UsniAdaptor;
/**
 * OrderPaymentDetailsTableBuilder class file.
 *
 * @package common\modules\order\db
 */
class OrderPaymentDetailsTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => Schema::TYPE_PK,
            'order_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'payment_method' => Schema::TYPE_STRING . '(164) NOT NULL',
            'payment_type' => Schema::TYPE_STRING . '(64)',
            'total_including_tax' => $this->decimal(10,2)->notNull(),
            'tax' => $this->decimal(10,2)->notNull()->defaultValue(0),
            'shipping_fee'  => $this->decimal(10,2)->notNull()->defaultValue(0)
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_order_id', 'order_id', false],
                    ['idx_payment_method', 'payment_method', false],
                    ['idx_payment_type', 'payment_type', false],
                    ['idx_total_including_tax', 'total_including_tax', false],
					['idx_tax', 'tax', false],
					['idx_shipping_fee', 'shipping_fee', false],
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected static function isTranslatable()
    {
        return true;
    }
    
    /**
     * @inheritdoc
     */
    protected function getForeignKeys()
    {
        $orderTableName    = UsniAdaptor::tablePrefix() . 'order';
        $paymentTableName  = UsniAdaptor::tablePrefix() . 'order_payment_details';
        return [
                  ['fk_' . $paymentTableName . '_order_id', $paymentTableName, 'order_id', $orderTableName, 'id', 'CASCADE', 'CASCADE']
               ];
    }
}