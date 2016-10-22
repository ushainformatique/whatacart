<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\cms\managers;

use usni\library\components\UiTableBuilder;
use yii\db\Schema;
/**
 * PageTranslatedTableBuilder class file.
 * @package common\modules\cms\managers
 */
class PageTranslatedTableBuilder extends UiTableBuilder
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
                'name' => Schema::TYPE_STRING . '(128) NOT NULL',
                'alias' => Schema::TYPE_STRING . '(128) NOT NULL',
                'menuitem' => Schema::TYPE_STRING . '(128) NOT NULL',
                'content' => Schema::TYPE_TEXT . ' DEFAULT NULL',
                'summary' => Schema::TYPE_TEXT . ' DEFAULT NULL',
                'metakeywords' => Schema::TYPE_TEXT . ' DEFAULT NULL',
                'metadescription' => Schema::TYPE_TEXT . ' DEFAULT NULL'
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
            ['idx_name', 'name', false],
            ['idx_alias', 'alias', false],
            ['idx_owner_id', 'owner_id', false],
            ['idx_language', 'language', false]
        ];
    }
}
