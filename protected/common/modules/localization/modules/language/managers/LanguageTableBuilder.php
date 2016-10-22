<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\language\managers;

use usni\library\components\UiTableBuilder;
use yii\db\Schema;
/**
 * TableBuilder class file.
 * 
 * @package common\modules\localization\modules\language\managers
 */

class LanguageTableBuilder extends UiTableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . '(64)',
            'locale' => Schema::TYPE_STRING . '(10)',
            'image' => Schema::TYPE_STRING . '(64)',
            'sort_order' => Schema::TYPE_SMALLINT . '(3)',
            'status' => Schema::TYPE_SMALLINT . '(1)',
            'code' => Schema::TYPE_STRING . '(10)',
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
            ['idx_status', 'status', false],
            ['idx_locale', 'locale', false],
            ['idx_sort_order', 'sort_order', false],
            ['idx_code', 'code', false],
        ];
    }
}