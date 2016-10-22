<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\managers;

use usni\library\components\UiTableBuilder;
use yii\db\Schema;
/**
 * ProductTableBuilder class file.
 * @package products\managers
 */
class ProductTableBuilder extends UiTableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => Schema::TYPE_PK,
            'model' => Schema::TYPE_STRING . '(64) NOT NULL',
            'price' => $this->decimal(10,2)->notNull(),
            'buy_price'=> $this->decimal(10,2)->notNull(),
            'image' => Schema::TYPE_STRING . '(64)',
            'status' => Schema::TYPE_SMALLINT . '(1) NOT NULL',
            'sku' => Schema::TYPE_STRING . '(16)',
            'quantity' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'initial_quantity' => $this->integer(11)->notNull(),
            'tax_class_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'minimum_quantity' => Schema::TYPE_INTEGER . '(11)',
            'subtract_stock' => Schema::TYPE_STRING . '(5)',
            'stock_status' => Schema::TYPE_SMALLINT . '(1) NOT NULL',
            'requires_shipping' => Schema::TYPE_SMALLINT . '(1) NOT NULL',
            'available_date' => Schema::TYPE_DATE,
            'manufacturer' => Schema::TYPE_STRING . '(64)',
            'is_featured' => Schema::TYPE_SMALLINT . '(1)',
            'location' => Schema::TYPE_STRING . '(64)',
            'length' => Schema::TYPE_INTEGER . '(16)',
            'width' => Schema::TYPE_INTEGER . '(16)',
            'height' => Schema::TYPE_INTEGER . '(16)',
            'date_available' => Schema::TYPE_DATE,
            'weight' => $this->decimal(10,2),
            'length_class'  => Schema::TYPE_INTEGER . '(16)',
            'weight_class'  => Schema::TYPE_INTEGER . '(16)'
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_model', 'model', false],
                    ['idx_price', 'price', false],
                    ['idx_status', 'status', false],
                    ['idx_quantity', 'quantity', false],
                    ['idx_sku', 'sku', false],
                    ['idx_stock_status', 'stock_status', false],
                    ['idx_available_date', 'available_date', false],
                    ['idx_manufacturer', 'manufacturer', false],
                    //['idx_data_category_id', 'data_category_id', false],
                    ['idx_tax_class_id', 'tax_class_id', false],
                    ['idx_location', 'location', false],
                    ['idx_length', 'length', false],
                    ['idx_width', 'width', false],
                    ['idx_height', 'height', false],
                    ['idx_length_class', 'length_class', false],
                    ['idx_weight_class', 'weight_class', false],
                    ['idx_buy_price', 'buy_price', false],
                    ['idx_initial_quantity', 'initial_quantity', false],
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