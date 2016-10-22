<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\managers;

use usni\library\components\UiTableBuilder;
use yii\db\Schema;
/**
 * OrderProductTableBuilder class file.
 * @package common\modules\order\managers
 */
class OrderProductTableBuilder extends UiTableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => Schema::TYPE_PK,
            'order_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'product_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'options'    => $this->text(),
            'displayed_options'    => $this->text(),
            'item_code'    => $this->string(128)->notNull(),
            'name' => Schema::TYPE_STRING . '(128) NOT NULL',
            'model' => Schema::TYPE_STRING . '(128) NOT NULL',
            'quantity' => Schema::TYPE_INTEGER . '(11)',
            'price' => $this->decimal(10,2)->notNull(),
            'options_price' => $this->decimal(10,2)->notNull(),
            'total' => $this->decimal(10,2)->notNull(),
            'tax' => $this->decimal(10,2)->notNull(),
            'reward' => Schema::TYPE_STRING . '(128)'
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
}