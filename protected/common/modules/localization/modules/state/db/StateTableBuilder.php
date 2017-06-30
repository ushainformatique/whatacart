<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\state\db;

use usni\library\db\TableBuilder;
/**
 * StateTableBuilder class file.
 * 
 * @package common\modules\localization\modules\state\db
 */
class StateTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => $this->primaryKey(),
            'country_id' => $this->integer(11)->notNull(),
            'status' => $this->smallInteger(1),
            'code' => $this->string(10),
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
            ['idx_status', 'status', false],
            ['idx_country', 'country_id', false],
            ['idx_code', 'code', false],
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