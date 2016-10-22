<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\dataCategories\managers;

use usni\library\components\UiTableBuilder;
use yii\db\Schema;
/**
 * DataCategoryTranslatedTableBuilder class file.
 * @package common\modules\dataCategories\managers
 */
class DataCategoryTranslatedTableBuilder extends UiTableBuilder
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
                'name' => Schema::TYPE_STRING . '(128) NOT NULL',
                'description' => Schema::TYPE_TEXT . ' DEFAULT NULL'
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
            ['idx_name', 'name', false],
            ['idx_owner_id', 'owner_id', false],
            ['idx_language', 'language', false]
        ];
    }
}