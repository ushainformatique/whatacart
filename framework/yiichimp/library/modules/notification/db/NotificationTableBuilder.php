<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\notification\db;

use usni\library\db\TableBuilder;
/**
 * NotificationTableBuilder class file
 * 
 * @package usni\library\modules\notification\managers
 */
class NotificationTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    { 
        return [
                'id'            => $this->primaryKey(11)->notNull(),
                'modulename'    => $this->string(16)->notNull(),
                'type'          => $this->string(16)->notNull(),
                'data'          => $this->binary()->notNull(),
                'status'        => $this->smallInteger(1)->notNull()->defaultValue(1),
                'priority'      => $this->smallInteger(1)->notNull()->defaultValue(1),
                'senddatetime'  => $this->dateTime()->null(),
            ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_modulename', 'modulename', false],
                    ['idx_type', 'type', false],
                    ['idx_status', 'status', false],
                    ['idx_priority', 'priority', false]
                ];
    }
}