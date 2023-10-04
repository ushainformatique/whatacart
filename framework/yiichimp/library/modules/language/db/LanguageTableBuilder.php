<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\language\db;

use usni\library\db\TableBuilder;
/**
 * TableBuilder class file.
 * 
 * @package usni\library\modules\language\db
 */
class LanguageTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => $this->primaryKey(11)->notNull(),
            'name' => $this->string(64)->notNull(),
            'locale' => $this->string(10)->notNull(),
            'image' => $this->string(64),
            'sort_order' => $this->integer(3),
            'status' => $this->smallInteger(1)->notNull(),
            'code' => $this->string(10)->notNull(),
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
            ['idx_status', 'status', false],
            ['idx_locale', 'locale', false],
            ['idx_sort_order', 'sort_order', false],
            ['idx_code', 'code', false],
        ];
    }
}