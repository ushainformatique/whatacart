<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\managers;

use usni\library\components\UiTableBuilder;
use yii\db\Schema;
/**
 * StoreTableBuilder class file.
 * @package common\modules\stores\managers
 */
class StoreTableBuilder extends UiTableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => Schema::TYPE_PK,
            'url' => Schema::TYPE_STRING . '(64)',
            'status' => Schema::TYPE_SMALLINT . '(1) NOT NULL',
            'data_category_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'is_default' => Schema::TYPE_SMALLINT . '(1) NOT NULL',
            'owner_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'theme' => Schema::TYPE_STRING . '(16)',
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_status', 'status', false],
                    ['idx_owner_id', 'owner_id', false],
                    ['idx_data_category_id', 'data_category_id', false],
                    ['idx_theme', 'theme', false]
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
