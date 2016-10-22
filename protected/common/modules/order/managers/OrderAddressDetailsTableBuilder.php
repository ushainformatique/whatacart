<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\managers;

use usni\library\components\UiTableBuilder;
use yii\db\Schema;
/**
 * OrderAddressDetailsTableBuilder class file.
 * @package common\modules\order\managers
 */
class OrderAddressDetailsTableBuilder extends UiTableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => Schema::TYPE_PK,
            'order_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'email' => Schema::TYPE_STRING . '(128) NOT NULL',
            'firstname' => Schema::TYPE_STRING . '(32)',
            'lastname' => Schema::TYPE_STRING . '(32)',
            'mobilephone' => Schema::TYPE_STRING . '(16)',
            'officephone' => Schema::TYPE_STRING . '(16)',
            'address1' => Schema::TYPE_STRING . '(128)',
            'address2' => Schema::TYPE_STRING . '(128)',
            'city' => Schema::TYPE_STRING . '(20)',
            'country' => Schema::TYPE_STRING . '(10)',
            'postal_code' => Schema::TYPE_STRING . '(16)',
            'state' => Schema::TYPE_STRING . '(20)',
            'type' => $this->integer(2),
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_order_id', 'order_id', false],
                    ['idx_firstname', 'firstname', false],
                    ['idx_lastname', 'lastname', false],
                    ['idx_city', 'city', false],
                    ['idx_country', 'country', false],
                    ['idx_postal_code', 'postal_code', false]
               ];
    }
}