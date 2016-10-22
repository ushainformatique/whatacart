<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace newsletter\managers;

use usni\library\components\UiTableBuilder;
use yii\db\Schema;
/**
 * NewsletterTranslatedTableBuilder class file.
 * @package newsletter\managers
 */
class NewsletterTranslatedTableBuilder extends UiTableBuilder
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
                'content' => Schema::TYPE_TEXT,
               ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
            ['idx_owner_id', 'owner_id', false],
            ['idx_language', 'language', false]
        ];
    }
}