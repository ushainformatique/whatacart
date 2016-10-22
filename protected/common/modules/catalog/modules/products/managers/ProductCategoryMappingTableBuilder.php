<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\managers;

use usni\library\components\UiTableBuilder;
use yii\db\Schema;
/**
 * ProductCategoryMappingTableBuilder class file.
 *
 * @package products\managers
 */
class ProductCategoryMappingTableBuilder extends UiTableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'product_id' => Schema::TYPE_INTEGER . '(11)',
            'category_id' => Schema::TYPE_INTEGER . '(11)',
            'data_category_id' => Schema::TYPE_INTEGER . '(11)'
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_product_id', 'product_id', false],
                    ['idx_category_id', 'category_id', false],
                    ['idx_data_category_id', 'data_category_id', false],
               ];
    }
}