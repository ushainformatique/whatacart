<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\dataCategories\managers;

use usni\library\components\UiTableBuilder;
use yii\db\Schema;
/**
 * DataCategoriesTableBuilder class file.
 * @package common\modules\dataCategories\managers
 */
class DataCategoryTableBuilder extends UiTableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => Schema::TYPE_PK,
            'status' => Schema::TYPE_SMALLINT . '(1) NOT NULL'
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_status', 'status', false]
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