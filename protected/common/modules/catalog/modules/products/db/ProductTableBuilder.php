<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\db;

use usni\library\db\TableBuilder;
/**
 * ProductTableBuilder class file.
 * 
 * @package products\db
 */
class ProductTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => $this->primaryKey(11),
            'type' => $this->smallInteger(1)->defaultValue(1),
            'model' => $this->string(64),
            'price' => $this->decimal(10,2)->defaultValue(0),
            'buy_price'=> $this->decimal(10,2)->defaultValue(0),
            'image' => $this->string(64),
            'status' => $this->smallInteger(1)->notNull(),
            'sku' => $this->string(16),
            'quantity' => $this->integer(11),
            'initial_quantity' => $this->integer(11),
            'tax_class_id' => $this->integer(11),
            'minimum_quantity' => $this->integer(11),
            'subtract_stock' => $this->string(5),
            'stock_status' => $this->smallInteger(1),
            'requires_shipping' => $this->smallInteger(1),
            'available_date' => $this->date(),
            'manufacturer' => $this->integer(11),
            'is_featured' => $this->smallInteger(1),
            'location' => $this->string(64),
            'length' => $this->integer(11),
            'width' => $this->integer(11),
            'height' => $this->integer(11),
            'date_available' => $this->date(),
            'weight' => $this->decimal(10,2),
            'length_class'  => $this->integer(11),
            'weight_class'  => $this->integer(11),
            'hits' => $this->integer(11)->defaultValue(0)->notNull(),
            'upc' => $this->string(12),
            'ean' => $this->string(14),
            'jan' => $this->string(13),
            'isbn' => $this->string(17),
            'mpn' => $this->string(64),
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
                    ['idx_tax_class_id', 'tax_class_id', false],
                    ['idx_location', 'location', false],
                    ['idx_length', 'length', false],
                    ['idx_width', 'width', false],
                    ['idx_height', 'height', false],
                    ['idx_length_class', 'length_class', false],
                    ['idx_weight_class', 'weight_class', false],
                    ['idx_buy_price', 'buy_price', false],
                    ['idx_initial_quantity', 'initial_quantity', false],
                    ['idx_type', 'type', false],
                    ['idx_hits', 'hits', false]
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