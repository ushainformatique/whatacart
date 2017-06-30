<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\db;

use usni\library\db\TableBuilder;
use usni\UsniAdaptor;
/**
 * ProductOptionMappingTableBuilder class file.
 *
 * @package products\db
 */
class ProductOptionMappingTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
                    'id'                => $this->primaryKey(11),
                    'product_id'        => $this->integer(11),
                    'option_id'         => $this->integer(11),
                    'required'          => $this->smallInteger(1),
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_product_id', 'product_id', false],
                    ['idx_option_id', 'option_id', false],
                    ['idx_required', 'required', false]
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getForeignKeys()
    {
        $productTableName  = UsniAdaptor::tablePrefix() . 'product';
        $mappingTableName  = UsniAdaptor::tablePrefix() . 'product_option_mapping';
        return [
                  ['fk_' . $mappingTableName . '_product_id', $mappingTableName, 'product_id', $productTableName, 'id', 'CASCADE', 'NO ACTION']
               ];
    }
}