<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace newsletter\db;

use usni\library\db\TableBuilder;
/**
 * NewsletterTableBuilder class file
 * 
 * @package newsletter\db
 */
class NewsletterTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => $this->primaryKey(),
            'store_id' => $this->integer(11)->notNull(),
            'to' => $this->integer(11)->notNull(),
            'subject' => $this->string(164)->notNull(),
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return[
                ['idx_store_id', 'store_id', false],
                ['idx_to', 'to', false],
                ['idx_subject', 'subject', false],
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
