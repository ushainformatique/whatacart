<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\users\db;

use usni\library\db\TableBuilder;
/**
 * PersonTableBuilder class file
 * 
 * @package usni\library\modules\users\db
 */
class PersonTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    { 
        return [
                'id'            => $this->primaryKey(11),
                'firstname'     => $this->string(32),
                'lastname'      => $this->string(32),
                'mobilephone'   => $this->string(16),
                'email'         => $this->string(64),
                'avatar'        => $this->string(128),
                'profile_image' => $this->string(255),
            ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_email', 'email', true]
               ];
    }
}
