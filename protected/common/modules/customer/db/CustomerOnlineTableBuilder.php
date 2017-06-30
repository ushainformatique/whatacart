<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\db;

use usni\library\db\TableBuilder;
/**
 * CustomerOnlineTableBuilder class file
 * 
 * @package customer\db
 */
class CustomerOnlineTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => $this->primaryKey(11),
            'ip' => $this->string(64),
            'customer_id' => $this->integer(11),
            'url' => $this->string(164),
            'referer' => $this->string(164)
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return[
                ['idx_ip', 'ip', false],
                ['idx_customer_id', 'customer_id', false]
            ];
    }
}
