<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\db;

use usni\library\db\TableBuilder;
use usni\library\utils\ArrayUtil;
/**
 * ProductOptionValueTranslatedTableBuilder class file.
 * 
 * @package products\db
 */
class ProductOptionValueTranslatedTableBuilder extends TableBuilder
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
            'value' => $this->string(128)->notNull(),
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        $indexes = [
                        ['idx_value', 'value', false],
                   ];
        return ArrayUtil::merge($indexes, $this->getCommonTranslatedAttributesIndexes());
    }
}