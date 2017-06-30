<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\db;

use usni\library\db\TableBuilder;
/**
 * ProductOptionMappingDetailsTableBuilder class file.
 * 
 * @package products\db
 */
class ProductOptionMappingDetailsTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
                    'id'                => $this->primaryKey(11),
                    'mapping_id'        => $this->integer(11)->notNull(),
                    'option_value_id'   => $this->string(32),
                    'quantity'          => $this->integer(10)->notNull(),
                    'subtract_stock'    => $this->smallInteger(1)->notNull(),
                    'price_prefix'      => $this->string(1),
                    'price'             => $this->decimal(10,2),
                    'weight_prefix'     => $this->string(1),
                    'weight'            => $this->decimal(10,2)
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_mapping_id', 'mapping_id', false],
                    ['idx_option_value_id', 'option_value_id', false],
                    ['idx_quantity', 'quantity', false],
                    ['idx_price_prefix', 'price_prefix', false],
                    ['idx_price', 'price', false],
                    ['idx_weight_prefix', 'weight_prefix', false],
                    ['idx_weight', 'weight', false]
               ];
    }
}