<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\auth\db;

use usni\library\db\TableBuilder;
/**
 * GroupMemberTableBuilder class file.
 * 
 * @package usni\library\modules\auth\db
 */
class GroupMemberTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'group_id' => $this->integer(11)->notNull(),
            'member_id' => $this->integer(11)->notNull(),
            'member_type' => $this->string(16)->notNull(),
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                  ['idx_member_type', 'member_type', false],
                  ['idx_group_member', 'group_id, member_id, member_type', true]
               ];        
    }
}
