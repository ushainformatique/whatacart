<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\auth\db;

use usni\library\db\TableBuilder;
/**
 * GroupTableBuilder class file.
 * 
 * @package usni\library\modules\auth\db
 */
class GroupTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => $this->primaryKey(11)->notNull(),
            'name'  => $this->string(64)->notNull(),
            'parent_id' => $this->integer(11)->notNull(),
            'level' => $this->integer(1)->notNull(),
            'status' => $this->integer(1)->notNull(),
            'category'  => $this->string(16)->notNull()->defaultValue('system'),
            'path'  => $this->text(),
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_level', 'level', false],
                    ['idx_status', 'status', false]
                ];
    }
}
