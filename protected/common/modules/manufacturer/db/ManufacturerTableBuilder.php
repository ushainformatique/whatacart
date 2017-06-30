<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\manufacturer\db;

use usni\library\db\TableBuilder;
/**
 * ManufacturerTableBuilder class file.
 * 
 * @package common\modules\manufacturer\db
 */
class ManufacturerTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => $this->primaryKey(11)->notNull(),
            'name' => $this->string(64)->notNull(),
            'image' => $this->string(64),
            'status' => $this->smallInteger(1),
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_name', 'name', false]
               ];
    }
}