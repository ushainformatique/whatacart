<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\currency\managers;

use usni\library\components\UiTableBuilder;
use yii\db\Schema;
/**
 * CurrencyTableBuilder class file.
 * @package common\modules\localization\modules\currency\managers
 */
class CurrencyTableBuilder extends UiTableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => Schema::TYPE_PK,
            'status' => Schema::TYPE_SMALLINT . '(1)',
            'value' => $this->decimal(10,2)->notNull(),
            'code'  => Schema::TYPE_STRING . '(10)',
            'symbol_left' => Schema::TYPE_STRING . '(10)',
            'symbol_right' => Schema::TYPE_STRING . '(10)',
            'decimal_place' => Schema::TYPE_STRING . '(3)'
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
?>