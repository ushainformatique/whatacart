<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\db;

use usni\library\db\TableBuilder;
/**
 * CustomerActivityTableBuilder class file
 * 
 * @package customer\db
 */
class CustomerActivityTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer(11)->notNull(),
            'key' => $this->string(128)->notNull(),
            'data' => $this->text()->notNull(),
            'ip' => $this->string(164)->notNull()
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return[
                ['idx_customer_id', 'customer_id', false],
                ['idx_key', 'key', false],
              ];
    }
}
