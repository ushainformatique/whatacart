<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\db;

use usni\library\db\TableBuilder;
/**
 * ZoneTableBuilder class file.
 * 
 * @package taxes\db
 */
class ZoneTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id'            => $this->primaryKey(),
            'country_id'    => $this->integer(11)->notNull(),
            'state_id'      => $this->integer(11)->notNull(),
            'zip'           => $this->string(16),
            'is_zip_range'  => $this->smallInteger(1),
            'from_zip'      => $this->string(16),
            'to_zip'        => $this->string(16)
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_country_id', 'country_id', false],
                    ['idx_state_id', 'state_id', false],
                    ['idx_zip', 'zip', false],
                    ['idx_is_zip_range', 'is_zip_range', false],
                    ['idx_from_zip', 'from_zip', false],
                    ['idx_to_zip', 'to_zip', false]
            ];
    }
    
    /**
     * @inheritdoc
     */
    protected static function isTranslatable()
    {
        return true;
    }
}