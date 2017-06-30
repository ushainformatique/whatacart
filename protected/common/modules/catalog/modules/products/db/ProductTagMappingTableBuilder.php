<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\db;

use usni\library\db\TableBuilder;
use usni\UsniAdaptor;
/**
 * ProductTagMappingTableBuilder class file.
 *
 * @package products\db
 */
class ProductTagMappingTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'product_id' => $this->integer(11),
            'tag_id' => $this->integer(11),
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_product_id', 'product_id', false],
                    ['idx_tag_id', 'tag_id', false],
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getForeignKeys()
    {
        $productTableName  = UsniAdaptor::tablePrefix() . 'product';
        $mappingTableName  = UsniAdaptor::tablePrefix() . 'product_tag_mapping';
        return [
                  ['fk_' . $mappingTableName . '_product_id', $mappingTableName, 'product_id', $productTableName, 'id', 'CASCADE', 'NO ACTION']
               ];
    }
}