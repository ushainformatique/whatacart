<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\managers;

use usni\library\components\UiTableBuilder;
use yii\db\Schema;
/**
 * ProductDiscountTableBuilder class file.
 * @package products\managers
 */
class ProductDiscountTableBuilder extends UiTableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => Schema::TYPE_PK,
            'group_id' => $this->integer(11)->notNull(),
            'quantity' => Schema::TYPE_INTEGER . '(10)',
            'priority' => Schema::TYPE_INTEGER . '(2)',
            'price'    => Schema::TYPE_DECIMAL . '(10,2)',
            'start_datetime' => Schema::TYPE_DATETIME,
            'end_datetime'   => Schema::TYPE_DATETIME,
            'product_id'     => Schema::TYPE_INTEGER . '(11) NOT NULL'        
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
}