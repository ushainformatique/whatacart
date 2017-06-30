<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\cms\db;

use usni\library\db\TableBuilder;
use usni\library\utils\ArrayUtil;
/**
 * PageTranslatedTableBuilder class file.
 * 
 * @package common\modules\cms\db
 */
class PageTranslatedTableBuilder extends TableBuilder
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
                'name' => $this->string(128)->notNull(),
                'alias' => $this->string(128)->notNull(),
                'menuitem' => $this->string(128)->notNull(),
                'content' => $this->text(),
                'summary' => $this->text(),
                'metakeywords' => $this->text(),
                'metadescription' => $this->text()
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        $indexes = [
                        ['idx_alias', 'alias', false]
                   ];
        return ArrayUtil::merge($indexes, $this->getCommonTranslatedAttributesIndexesWithName());
    }
}
