<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace productCategories\db;

use usni\library\db\TableBuilder;
use usni\library\utils\ArrayUtil;
/**
 * ProductCategoryTranslatedTableBuilder class file.
 * 
 * @package productCategories\db
 */
class ProductCategoryTranslatedTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => $this->primaryKey(11),
            'owner_id' => $this->integer(11)->notNull(),
            'language' => $this->string(10)->notNull(),
            'name' => $this->string(128)->notNull(),
            'alias' => $this->string(128)->notNull(),
            'metakeywords' => $this->string(128),
            'metadescription' => $this->string(128),
            'description' => $this->text()
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        $indexes = [
                        ['idx_id', 'id', true],
                        ['idx_alias', 'alias', false],
                   ];
        return ArrayUtil::merge($indexes, $this->getCommonTranslatedAttributesIndexesWithName());
    }
}