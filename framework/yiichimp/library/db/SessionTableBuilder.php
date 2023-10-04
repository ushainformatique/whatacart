<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace usni\library\db;

use usni\library\db\TableBuilder;
use yii\db\Schema;
use usni\UsniAdaptor;
/**
 * SessionTableBuilder class file.
 *
 * @package usni\library\db
 */
class SessionTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => Schema::TYPE_STRING . '(40) PRIMARY KEY NOT NULL',
            'expire' => $this->integer(11),
            'data' => $this->binary()
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_expire', 'expire', false],
               ];
    }
    
    /**
     * @inheritdoc
     */
    public function getTableName()
    {
        return UsniAdaptor::app()->db->tablePrefix.'session';
    }
}
