<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\managers;

use usni\library\components\UiTableBuilder;
use yii\db\Schema;
/**
 * TaxRateTableBuilder class file.
 * @package taxes\managers
 */
class TaxRateTableBuilder extends UiTableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => Schema::TYPE_PK,
            'value' => Schema::TYPE_STRING . '(64) NOT NULL',
            'tax_zone_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'type' => Schema::TYPE_STRING . '(64) NOT NULL',
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_value', 'value', false],
                    ['idx_tax_zone_id', 'tax_zone_id', false],
                    ['idx_type', 'type', false],
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