<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\state\db;

use usni\library\db\TableBuilder;
/**
 * StateTranslatedTableBuilder class file.
 * 
 * @package common\modules\localization\modules\state\db
 */
class StateTranslatedTableBuilder extends TableBuilder
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
            'name' => $this->string(64)->notNull()
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