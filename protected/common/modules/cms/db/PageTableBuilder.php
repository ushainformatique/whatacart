<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\cms\db;

use usni\library\db\TableBuilder;
/**
 * PageTableBuilder class file.
 * 
 * @package common\modules\cms\db
 */
class PageTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => $this->primaryKey(),
            'status' => $this->smallInteger(1)->notNull(),
            'parent_id' => $this->integer(11),
            'custom_url' => $this->string(64),
            'level' => $this->smallInteger(1)->notNull(),
            'path'  => $this->text(),
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_status', 'status', false],
                    ['idx_parent_id', 'parent_id', false],
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
