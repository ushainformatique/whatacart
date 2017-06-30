<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\db;

use usni\library\db\TableBuilder;
use usni\UsniAdaptor;
/**
 * ProductDiscountTableBuilder class file.
 * 
 * @package products\db
 */
class ProductDiscountTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
                    'id' => $this->primaryKey(11),
                    'group_id' => $this->integer(11)->notNull(),
                    'quantity' => $this->integer(10)->notNull(),
                    'priority' => $this->integer(2),
                    'price' => $this->decimal(10,2)->notNull(),
                    'start_datetime' => $this->dateTime(),
                    'end_datetime' => $this->dateTime(),
                    'product_id' => $this->integer(11)->notNull()     
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_product_id', 'product_id', false],
                    ['idx_group_id', 'group_id', false],
                    ['idx_quantity', 'quantity', false],
                    ['idx_priority', 'priority', false],
                    ['idx_price', 'price', false],
                    ['idx_start_datetime', 'start_datetime', false],
                    ['idx_end_datetime', 'end_datetime', false],
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getForeignKeys()
    {
        $productTableName   = UsniAdaptor::tablePrefix() . 'product';
        $discountTableName  = UsniAdaptor::tablePrefix() . 'product_discount';
        return [
                  ['fk_' . $discountTableName . '_product_id', $discountTableName, 'product_id', $productTableName, 'id', 'CASCADE', 'CASCADE']
               ];
    }
}