<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace newsletter\managers;

use usni\library\components\UiTableBuilder;
use yii\db\Schema;
/**
 * NewsletterCustomersTableBuilder class file
 * @package newsletter\managers
 */
class NewsletterCustomersTableBuilder extends UiTableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => Schema::TYPE_PK,
            'customer_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'email' => Schema::TYPE_STRING . '(164) NOT NULL',
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
