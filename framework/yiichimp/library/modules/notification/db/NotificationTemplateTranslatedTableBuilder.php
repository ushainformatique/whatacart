<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\notification\db;

use usni\library\db\TableBuilder;
use usni\library\utils\ArrayUtil;
/**
 * NotificationTemplateTranslatedTableBuilder class file
 * 
 * @package usni\library\modules\notification\managers
 */
class NotificationTemplateTranslatedTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    { 
        return [
                'id'            => $this->primaryKey(11)->notNull(),
                'owner_id'      => $this->integer(11)->notNull(),
                'language'      => $this->string(10)->notNull(),
                'subject'       => $this->string(128)->notNull(),
                'content'       => $this->binary()->notNull()
            ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        $indexes = [
                        ['idx_subject', 'subject', false]
                   ];
        return ArrayUtil::merge($indexes, $this->getCommonTranslatedAttributesIndexes());
    }
}