<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\db;

use usni\library\db\TableBuilder;
/**
 * StoreTranslatedTableBuilder class file.
 * 
 * @package common\modules\stores\db
 */
class StoreTranslatedTableBuilder extends TableBuilder
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
                'name'          => $this->string(128)->notNull(),
                'description'   => $this->text(),
                'metakeywords'  => $this->text(),
                'metadescription' => $this->text()
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