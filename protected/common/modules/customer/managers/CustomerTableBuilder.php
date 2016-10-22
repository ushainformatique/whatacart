<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\managers;

use usni\library\components\UiTableBuilder;
use yii\db\Schema;
/**
 * CustomerTableBuilder class file
 * @package customer\managers
 */
class CustomerTableBuilder extends UiTableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => Schema::TYPE_PK,
            'username' => Schema::TYPE_STRING . '(64) NOT NULL',
            'unique_id' => $this->integer(11)->notNull(),
            'password_reset_token' => Schema::TYPE_STRING . '(128) NOT NULL',
            'password_hash' => Schema::TYPE_STRING . '(128) NOT NULL',
            'auth_key' => Schema::TYPE_STRING . '(128) NOT NULL',
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL',
            'person_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'login_ip' => Schema::TYPE_STRING . '(20) NOT NULL',
            'last_login' => Schema::TYPE_DATETIME . ' NOT NULL',
            'timezone' => Schema::TYPE_STRING . '(32)',
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
