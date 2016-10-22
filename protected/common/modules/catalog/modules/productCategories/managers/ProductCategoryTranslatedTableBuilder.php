<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace productCategories\managers;

use usni\library\components\UiTableBuilder;
use yii\db\Schema;
/**
 * ProductCategoryTranslatedTableBuilder class file.
 * @package productCategories\managers
 */
class ProductCategoryTranslatedTableBuilder extends UiTableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => Schema::TYPE_PK,
            'owner_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'language' => Schema::TYPE_STRING . '(10) NOT NULL',
            'name' => Schema::TYPE_STRING . '(64) NOT NULL',
            'alias' => Schema::TYPE_STRING . '(16) NOT NULL',
            'metakeywords' => Schema::TYPE_STRING . '(128)',
            'metadescription' => Schema::TYPE_STRING . '(128)',
            'description' => Schema::TYPE_TEXT,
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_id', 'id', true],
                    ['idx_owner_id', 'owner_id', false],
                    ['idx_language', 'language', false],
                    ['idx_name', 'name', false],
                    ['idx_alias', 'alias', false],
               ];
    }
}