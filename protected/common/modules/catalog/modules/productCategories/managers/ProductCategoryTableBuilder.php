<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace productCategories\managers;

use usni\library\components\UiTableBuilder;
use yii\db\Schema;
/**
 * ProductCategoryTableBuilder class file.
 * @package productCategories\managers
 */
class ProductCategoryTableBuilder extends UiTableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => Schema::TYPE_PK,
            'image' => Schema::TYPE_STRING . '(64)',
            'parent_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'level' => Schema::TYPE_INTEGER . '(2)',
            'status' => Schema::TYPE_SMALLINT . '(1) NOT NULL',
            'displayintopmenu' => Schema::TYPE_SMALLINT . '(1) NULL',
            'data_category_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'code' => Schema::TYPE_STRING . '(164)',
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