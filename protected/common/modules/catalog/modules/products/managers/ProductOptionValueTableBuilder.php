<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\managers;

use usni\library\components\UiTableBuilder;
use yii\db\Schema;
/**
 * ProductOptionValueTableBuilder class file.
 * @package products\managers
 */
class ProductOptionValueTableBuilder extends UiTableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => Schema::TYPE_PK,
            'option_id' => Schema::TYPE_INTEGER . '(11) NOT NULL'
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_option_id', 'option_id', false],
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