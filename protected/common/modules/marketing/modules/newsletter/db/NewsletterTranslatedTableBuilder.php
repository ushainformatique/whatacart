<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace newsletter\db;

use usni\library\db\TableBuilder;
/**
 * NewsletterTranslatedTableBuilder class file.
 * 
 * @package newsletter\db
 */
class NewsletterTranslatedTableBuilder extends TableBuilder
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
                'content' => $this->text(),
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