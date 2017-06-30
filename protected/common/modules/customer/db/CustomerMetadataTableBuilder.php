<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\db;

use usni\library\db\TableBuilder;
/**
 * CustomerMetadataTableBuilder class file
 * 
 * @package customer\db
 */
class CustomerMetadataTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id'    => $this->primaryKey(11),
            'customer_id' => $this->integer(11),
            'cart'  => $this->text(),
            'wishlist' => $this->text(),
            'compareproducts' => $this->text(),
            'currency' => $this->string(128),
            'language' => $this->string(128),
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
