<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\users\db;

use usni\library\db\TableBuilder;
/**
 * AddressTableBuilder class file.
 * 
 * @package usni\library\modules\users\db
 */
class AddressTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    { 
        return [
                'id'            => $this->primaryKey(11),
                'address1'      => $this->string(128),
                'address2'      => $this->string(128),
                'city'          => $this->string(20),
                'state'         => $this->string(20),
                'country'       => $this->string(10),
                'postal_code'   => $this->string(16),
                'relatedmodel'  => $this->string(32),
                'relatedmodel_id' => $this->integer(11),
                'type'            => $this->smallInteger(1),
                'status'          => $this->smallInteger(1),
            ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_country', 'country', false],
                    ['idx_postal_code', 'postal_code', false]
               ];
    }
}