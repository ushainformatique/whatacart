<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\currency\db;

use usni\library\db\TableBuilder;
/**
 * CurrencyTableBuilder class file.
 * 
 * @package common\modules\localization\modules\currency\db
 */
class CurrencyTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => $this->primaryKey(),
            'status' => $this->smallInteger(1),
            'value' => $this->decimal(10, 2)->notNull(),
            'code'  => $this->string(10)->notNull(),
            'symbol_left' => $this->string(10),
            'symbol_right' => $this->string(10),
            'decimal_place' => $this->string(3)
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
            ['idx_symbol_left', 'symbol_left', false],
            ['idx_code', 'code', false],
            ['idx_symbol_right', 'symbol_right', false],
            ['idx_status', 'status', false],
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