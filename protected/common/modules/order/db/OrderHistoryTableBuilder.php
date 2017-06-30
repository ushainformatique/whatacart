<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\db;

use usni\library\db\TableBuilder;
use usni\UsniAdaptor;
/**
 * OrderHistoryTableBuilder class file.
 * 
 * @package common\modules\order\db
 */
class OrderHistoryTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(11),
            'status' => $this->smallInteger(1),
            'notify_customer' => $this->smallInteger(1),
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_order_id', 'order_id', false],
                    ['idx_status', 'status', false]
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected static function isTranslatable()
    {
        return true;
    }
    
    /**
     * @inheritdoc
     */
    protected function getForeignKeys()
    {
        $orderTableName    = UsniAdaptor::tablePrefix() . 'order';
        $historyTableName  = UsniAdaptor::tablePrefix() . 'order_history';
        return [
                  ['fk_' . $historyTableName . '_order_id', $historyTableName, 'order_id', $orderTableName, 'id', 'CASCADE', 'CASCADE']
               ];
    }
}