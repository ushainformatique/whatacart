<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace productCategories\db;

use usni\library\db\TableBuilder;
/**
 * ProductCategoryTableBuilder class file.
 * 
 * @package productCategories\db
 */
class ProductCategoryTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => $this->primaryKey(11),
            'image' => $this->string(64),
            'parent_id' => $this->integer(11),
            'level' => $this->integer(2),
            'status' => $this->smallInteger(1),
            'displayintopmenu' => $this->smallInteger(1),
            'data_category_id' => $this->integer(11)->notNull(),
            'code' => $this->string(164)->notNull(),
            'path'  => $this->text(),
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_parent_id', 'parent_id', false],
                    ['idx_status', 'status', false],
                    ['idx_data_category_id', 'data_category_id', false],
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