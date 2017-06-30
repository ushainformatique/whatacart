<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\db;

use usni\library\db\TableBuilder;
use yii\db\Schema;
/**
 * OrderTableBuilder class file.
 *
 * @package common\modules\order\db
 */
class OrderTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => Schema::TYPE_PK,
            'customer_id' => Schema::TYPE_INTEGER . '(11)',
            'shipping' => $this->string(64),
            'status' => Schema::TYPE_SMALLINT. '(1)',
            'store_id' => Schema::TYPE_INTEGER . '(11)',
            'shipping_fee'  => $this->decimal(10,2)->defaultValue(0),
            'unique_id' => $this->integer(11)->notNull(),
            'currency_code' => $this->string(10)->notNull(),
            'currency_conversion_value' => $this->float(10, 2)->notNull()->defaultValue(1.00),
            'interface' => $this->string('6')->notNull(),
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_customer_id', 'customer_id', false],
                    ['idx_store_id', 'store_id', false],
                    ['idx_status', 'status', false],
                    ['idx_unique_id', 'unique_id', false],
                    ['idx_currency_code', 'currency_code', false]
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