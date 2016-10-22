<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\managers;

use usni\library\components\UiTableBuilder;
use yii\db\Schema;
/**
 * CustomerMetadataTableBuilder class file
 * @package customer\managers
 */
class CustomerMetadataTableBuilder extends UiTableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id'    => Schema::TYPE_PK,
            'customer_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'cart'  => Schema::TYPE_TEXT,
            'wishlist' => Schema::TYPE_TEXT,
            'compareproducts' => Schema::TYPE_STRING . '(128)',
            'currency' => Schema::TYPE_STRING . '(128)',
            'language' => Schema::TYPE_STRING . '(128)',
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return[
                ['idx_customer_id', 'customer_id', false],
                ['idx_currency', 'currency', false],
                ['idx_language', 'language', false]
            ];
    }
}
