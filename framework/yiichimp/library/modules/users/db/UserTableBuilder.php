<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\users\db;

use usni\library\db\TableBuilder;
/**
 * UserTableBuilder class file.
 * 
 * @package usni\library\modules\users\db
 */
class UserTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => $this->primaryKey(11),
            'username' => $this->string(64)->notNull(),
            'password_reset_token' => $this->string(128),
            'password_hash' => $this->string(128)->notNull(),
            'auth_key' => $this->string(128),
            'status' => $this->smallInteger(1),
            'person_id' => $this->integer(11),
            'login_ip' => $this->string(20),
            'last_login' => $this->dateTime(),
            'timezone' => $this->string(32),
            'type' => $this->string(16),
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return[
                ['idx_status', 'status', false],
                ['idx_timezone', 'timezone', false],
                ['idx_username', 'username', true],
                ['idx_person_id', 'person_id', true]
            ];
    }
}
