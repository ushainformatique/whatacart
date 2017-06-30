<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\db;

use usni\library\db\TableBuilder;
use usni\UsniAdaptor;
/**
 * ProductReviewTableBuilder class file.
 *
 * @package products\db
 */
class ProductReviewTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull(),
            'status' => $this->smallInteger(1)->notNull(),
            'product_id' => $this->integer(11)->notNull(),
            'email' => $this->string(64)->notNull()
            ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_product_id', 'product_id', false],
                    ['idx_status', 'status', false],
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected static function isTranslatable()
    {
        return true;
    }
    
    /**
     * @inheritdoc
     */
    protected function getForeignKeys()
    {
        $productTableName   = UsniAdaptor::tablePrefix() . 'product';
        $reviewTableName    = UsniAdaptor::tablePrefix() . 'product_review';
        return [
                  ['fk_' . $reviewTableName . '_product_id', $reviewTableName, 'product_id', $productTableName, 'id', 'CASCADE', 'NO ACTION']
               ];
    }
}