<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\db;

use usni\library\db\TableBuilder;
/**
 * CustomerTableBuilder class file.
 * 
 * @package customer\db
 */
class CustomerTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => $this->primaryKey(11),
            'username' => $this->string(64)->notNull(),
            'unique_id' => $this->integer(11)->notNull(),
            'password_reset_token' => $this->string(128),
            'password_hash' => $this->string(128),
            'auth_key' => $this->string(128),
            'status' => $this->smallInteger(),
            'person_id' => $this->integer(11),
            'login_ip' => $this->string(20),
            'last_login' => $this->dateTime(),
            'timezone' => $this->string(32),
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return[
                ['idx_status', 'status', false],
                ['idx_username', 'username', true]
            ];
    }
}
