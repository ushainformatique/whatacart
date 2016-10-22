<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\managers;

use usni\library\components\UiTableBuilder;
/**
 * InvoiceTableBuilder class file.
 * @package common\modules\order\managers
 */
class InvoiceTableBuilder extends UiTableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => $this->primaryKey(11)->notNull(),
            'unique_id' => $this->integer(16)->notNull(),
            'order_id' => $this->integer(11)->notNull(),
            'price_excluding_tax' => $this->decimal(10,2)->notNull(),
            'tax' => $this->decimal(10,2)->notNull(),
            'shipping_fee' => $this->decimal(10,2)->notNull(),
            'total_items' => $this->integer(11)->notNull()
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_order_id', 'order_id', false],
                    ['idx_unique_id', 'unique_id', false]
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected static function isTranslatable()
    {
        return true;
    }
}