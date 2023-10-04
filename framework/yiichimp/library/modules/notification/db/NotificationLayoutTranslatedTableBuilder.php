<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\notification\db;

use usni\library\db\TableBuilder;
/**
 * NotificationLayoutTranslatedTableBuilder class file
 *
 * @package usni\library\modules\notification\managers
 */
class NotificationLayoutTranslatedTableBuilder extends TableBuilder
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
            'name'          => $this->string(64)->notNull(),
            'content'       => $this->binary()->notNull()
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return $this->getCommonTranslatedAttributesIndexesWithName();
    }
}