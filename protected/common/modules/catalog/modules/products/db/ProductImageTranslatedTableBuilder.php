<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\db;

use usni\library\db\TableBuilder;
use usni\library\utils\ArrayUtil;
/**
 * ProductImageTranslatedTableBuilder class file.
 * 
 * @package products\db
 */
class ProductImageTranslatedTableBuilder extends TableBuilder
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
                    'caption' => $this->string(128)->notNull()
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        $indexes = [
                        ['idx_caption', 'caption', false]
                   ];
        return ArrayUtil::merge($indexes, $this->getCommonTranslatedAttributesIndexes());
    }
}
