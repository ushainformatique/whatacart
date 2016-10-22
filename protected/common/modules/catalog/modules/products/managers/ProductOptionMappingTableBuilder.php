<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\managers;

use usni\library\components\UiTableBuilder;
use yii\db\Schema;
/**
 * ProductOptionMappingTableBuilder class file.
 *
 * @package products\managers
 */
class ProductOptionMappingTableBuilder extends UiTableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
                    'id'                => Schema::TYPE_PK,
                    'product_id'        => Schema::TYPE_INTEGER . '(11)',
                    'option_id'         => Schema::TYPE_INTEGER . '(11)',
                    'required'          => Schema::TYPE_SMALLINT . '(1)',
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
}