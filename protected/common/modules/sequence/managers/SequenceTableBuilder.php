<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\sequence\managers;

use usni\library\components\UiTableBuilder;
use yii\db\Schema;
/**
 * SequenceTableBuilder class file.
 * @package common\modules\sequence\managers
 */
class SequenceTableBuilder extends UiTableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
                    'id' => Schema::TYPE_PK,
                    'invoice_sequence_no' => $this->string(11)->notNull(),
                    'customer_sequence_no' => $this->string(11)->notNull(),
                    'order_sequence_no' => $this->string(11)->notNull(),
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_invoice_sequence_no', 'invoice_sequence_no', false],
                    ['idx_customer_sequence_no', 'customer_sequence_no', false],
                    ['idx_order_sequence_no', 'order_sequence_no', false],
               ];
    }
}