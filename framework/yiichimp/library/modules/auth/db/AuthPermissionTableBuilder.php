<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\auth\db;

use usni\library\db\TableBuilder;
/**
 * AuthPermissionTableBuilder class file.
 * 
 * @package usni\library\modules\auth\db
 */
class AuthPermissionTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => $this->primaryKey(11)->notNull(),
            'name' => $this->string(64)->notNull(),
            'alias' => $this->string(64)->notNull(),
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
                    ['idx_name', 'name', false],
                    ['idx_alias', 'alias', false],
                    ['idx_resource', 'resource', false],
                    ['idx_module', 'module', false],
                    ['idx_permission', 'name, module, resource, alias', true],
                ];
    }
}
