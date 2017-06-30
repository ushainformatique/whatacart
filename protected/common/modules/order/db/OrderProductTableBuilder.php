<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\db;

use usni\library\db\TableBuilder;
use usni\UsniAdaptor;
/**
 * OrderProductTableBuilder class file.
 * 
 * @package common\modules\order\db
 */
class OrderProductTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => $this->primaryKey(11)->notNull(),
            'order_id' => $this->integer(11)->notNull(),
            'product_id' => $this->integer(11)->notNull(),
            'options'    => $this->text(),
            'displayed_options'    => $this->text(),
            'item_code'    => $this->string(128),
            'name' => $this->string(128),
            'model' => $this->string(128),
            'quantity' => $this->integer(11),
            'price' => $this->decimal(10,2)->defaultValue(0),
            'options_price' => $this->decimal(10,2)->defaultValue(0),
            'total' => $this->decimal(10,2)->defaultValue(0),
            'tax' => $this->decimal(10,2)->defaultValue(0),
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_order_id', 'order_id', false],
                    ['idx_product_id', 'product_id', false],
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getForeignKeys()
    {
        $orderTableName         = UsniAdaptor::tablePrefix() . 'order';
        $orderProductTableName  = UsniAdaptor::tablePrefix() . 'order_product';
        return [
                  ['fk_' . $orderProductTableName . '_order_id', $orderProductTableName, 'order_id', $orderTableName, 'id', 'CASCADE', 'CASCADE']
               ];
    }
}