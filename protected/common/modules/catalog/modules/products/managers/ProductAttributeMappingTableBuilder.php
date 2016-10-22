<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\managers;

use usni\library\components\UiTableBuilder;
use yii\db\Schema;
/**
 * ProductAttributeMappingTableBuilder class file.
 * @package products\managers
 */
class ProductAttributeMappingTableBuilder extends UiTableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
                    'id'            => Schema::TYPE_PK,
                    'product_id'    => Schema::TYPE_INTEGER . '(11)',
                    'attribute_id'  => Schema::TYPE_INTEGER . '(11)',
                    'attribute_value'  => Schema::TYPE_STRING . '(32)'
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_product_id', 'product_id', false],
                    ['idx_attribute_id', 'attribute_id', false],
                    ['idx_attribute_value', 'attribute_value', false],
               ];
    }
}