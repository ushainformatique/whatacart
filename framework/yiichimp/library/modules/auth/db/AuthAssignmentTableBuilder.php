<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\auth\db;

use usni\library\db\TableBuilder;
/**
 * AuthAssignmentTableBuilder class file.
 * 
 * @package usni\library\modules\auth\db
 */
class AuthAssignmentTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
                    'identity_name' => $this->string(32)->notNull(),
                    'identity_type' => $this->string(16)->notNull(),
                    'permission' => $this->string(64)->notNull(),
                    'resource' => $this->string(32)->notNull(),
                    'module' => $this->string(32)->notNull(),
                ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_identity_name',   'identity_name', false],
                    ['idx_identity_type', 'identity_type', false],
                    ['idx_permission', 'permission', false]
            ];
    }
}