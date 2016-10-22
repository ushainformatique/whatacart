<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\managers;

use usni\library\components\UiTableBuilder;
use yii\db\Schema;
/**
 * ZoneTableBuilder class file.
 * @package taxes\managers
 */
class ZoneTableBuilder extends UiTableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id'            => Schema::TYPE_PK,
            'country_id'    => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'state_id'      => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'zip'           => $this->string(16),
            'is_zip_range'  => $this->smallInteger(1)->notNull(),
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