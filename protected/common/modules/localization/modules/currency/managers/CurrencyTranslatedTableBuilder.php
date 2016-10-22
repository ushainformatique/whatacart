<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\currency\managers;

use usni\library\components\UiTableBuilder;
use yii\db\Schema;
/**
 * CurrencyTranslatedTableBuilder class file.
 * @package common\modules\localization\modules\currency\managers
 */
class CurrencyTranslatedTableBuilder extends UiTableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => Schema::TYPE_PK,
            'owner_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'language' => Schema::TYPE_STRING . '(10) NOT NULL',
            'name' => Schema::TYPE_STRING . '(64)'
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
            ['idx_name', 'name', false],
            ['idx_owner_id', 'owner_id', false],
            ['idx_language', 'language', false]
        ];
    }
}
?>