<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\managers;

use usni\library\components\UiTableBuilder;
use yii\db\Schema;
/**
 * ProductRelatedProductMappingTableBuilder class file.
 * @package products\managers
 */
class ProductRelatedProductMappingTableBuilder extends UiTableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'product_id' => Schema::TYPE_INTEGER . '(11)',
            'related_product_id' => Schema::TYPE_INTEGER . '(11)',
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_product_id', 'product_id', false],
                    ['idx_related_product_id', 'related_product_id', false],
               ];
    }
}