<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\cms\managers;

use usni\library\components\UiTableBuilder;
use yii\db\Schema;
/**
 * PageTableBuilder class file.
 * @package common\modules\cms\managers
 */
class PageTableBuilder extends UiTableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => Schema::TYPE_PK,
            'status' => Schema::TYPE_SMALLINT . '(1) NOT NULL',
            'parent_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'custom_url' => Schema::TYPE_STRING . '(64)',
            'theme' => Schema::TYPE_STRING . '(64) NOT NULL'
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_status', 'status', false],
                    ['idx_theme', 'theme', false],
                    ['idx_parent_id', 'parent_id', false],
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
