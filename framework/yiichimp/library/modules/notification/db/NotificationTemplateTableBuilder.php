<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\notification\db;

use usni\library\db\TableBuilder;
/**
 * NotificationTemplateTableBuilder class file
 * 
 * @package usni\library\modules\notification\managers
 */
class NotificationTemplateTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {  
        return [
                'id'            => $this->primaryKey(11)->notNull(),
                'type'          => $this->string(10)->notNull(),
                'notifykey'     => $this->string(32)->notNull(),
                'layout_id'     => $this->integer(11)->null(),
                'status'        => $this->smallInteger(1)->notNull()->defaultValue(1),
            ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_notifykey', 'notifykey', false],
                    ['idx_type', 'type', false],
                    ['idx_status', 'status', false]
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