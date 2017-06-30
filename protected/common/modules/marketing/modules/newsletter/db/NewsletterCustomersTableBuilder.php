<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace newsletter\db;

use usni\library\db\TableBuilder;
/**
 * NewsletterCustomersTableBuilder class file.
 * 
 * @package newsletter\db
 */
class NewsletterCustomersTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer(11)->notNull(),
            'email' => $this->string(164)->notNull(),
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return[
                ['idx_customer_id', 'customer_id', false],
                ['idx_email', 'email', false]
            ];
    }
}
