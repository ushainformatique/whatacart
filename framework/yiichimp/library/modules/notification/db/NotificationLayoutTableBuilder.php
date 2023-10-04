<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\notification\db;

use usni\library\db\TableBuilder;
/**
 * NotificationLayoutTableBuilder class file
 * 
 * @package usni\library\modules\notification\managers
 */
class NotificationLayoutTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    { 
          return [
                'id'            => $this->primaryKey(11)->notNull(),
                'status'        => $this->smallInteger(1)->notNull()->defaultValue(1),
            ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [['idx_status', 'status', false]];
    }
    
    /**
     * @inheritdoc
     */
    protected static function isTranslatable()
    {
        return true;
    }
}