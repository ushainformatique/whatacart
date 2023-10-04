<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\db;

use usni\library\db\TableBuilder;
/**
 * ConfigurationTableBuilder class file
 * 
 * @package usni\library\db
 */
class ConfigurationTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    { 
        return [
                'id'            => $this->primaryKey(11),
                'module'        => $this->string(32)->notNull(),
                'key'           => $this->string(32)->notNull(),
                'value'         => $this->text()
            ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_module', 'module', false],
                    ['idx_key', 'key', false]
               ];
    }
}