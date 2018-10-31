<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\db;

use usni\library\db\TableBuilder;
/**
 * StoreTableBuilder class file.
 * 
 * @package common\modules\stores\db
 */
class StoreTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => $this->primaryKey(11)->notNull(),
            'url' => $this->string(64),
            'status' => $this->smallInteger(1)->notNull(),
            'data_category_id' => $this->integer(11)->notNull(),
            'is_default' => $this->smallInteger(1)->notNull()->defaultValue(0),
            'owner_id' => $this->integer(11)->notNull(),
            'theme' => $this->string(128),
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
