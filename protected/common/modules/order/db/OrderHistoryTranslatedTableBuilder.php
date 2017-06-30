<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\db;

use usni\library\db\TableBuilder;
/**
 * OrderHistoryTranslatedTableBuilder class file.
 * 
 * @package common\modules\order\db
 */
class OrderHistoryTranslatedTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => $this->primaryKey(),
            'owner_id' => $this->integer(11)->notNull(),
            'language' => $this->string(10)->notNull(),
            'comment' => $this->string(255),
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return $this->getCommonTranslatedAttributesIndexes();
    }
}