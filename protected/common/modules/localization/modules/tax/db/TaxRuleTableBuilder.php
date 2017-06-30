<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\db;

use usni\library\db\TableBuilder;
/**
 * TaxRuleTableBuilder class file.
 * 
 * @package taxes\db
 */
class TaxRuleTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => $this->primaryKey(),
            'based_on' => $this->string(16)->notNull(),
            'type' => $this->string(64)->notNull(),
            'value' => $this->string(64)->notNull()
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_based_on', 'based_on', false],
                    ['idx_type', 'type', false],
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