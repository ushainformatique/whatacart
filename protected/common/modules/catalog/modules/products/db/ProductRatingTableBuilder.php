<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\db;

use usni\library\db\TableBuilder;
use usni\UsniAdaptor;
/**
 * ProductRatingTableBuilder class file.
 * 
 * @package products\db
 */
class ProductRatingTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => $this->primaryKey(11)->notNull(),
            'rating' => $this->decimal(10,2)->notNull(),
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
                    ['idx_rating', 'rating', false],
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getForeignKeys()
    {
        $productTableName  = UsniAdaptor::tablePrefix() . 'product';
        $mappingTableName  = UsniAdaptor::tablePrefix() . 'product_rating';
        return [
                  ['fk_' . $mappingTableName . '_product_id', $mappingTableName, 'product_id', $productTableName, 'id', 'CASCADE', 'NO ACTION']
               ];
    }
}