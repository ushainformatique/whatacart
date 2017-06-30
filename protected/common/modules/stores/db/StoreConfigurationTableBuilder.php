<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\db;

use usni\library\db\TableBuilder;
/**
 * StoreConfigurationTableBuilder class file.
 * 
 * @package common\modules\stores\db
 */
class StoreConfigurationTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => $this->primaryKey(11),
            'store_id'  => $this->integer(11)->notNull(),
            'category'  => $this->string(32)->notNull(),
            'code'      => $this->string(128)->notNull(),
            'key'       => $this->string(128)->notNull(),
            'value'     => $this->text()->notNull()
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_store_id', 'store_id', false],
                    ['idx_category', 'category', false],
                    ['idx_code', 'code', false],
                    ['idx_key', 'key', false],
                    ['idx_store_code_key', 'store_id, code, key', true]
               ];
    }
}
