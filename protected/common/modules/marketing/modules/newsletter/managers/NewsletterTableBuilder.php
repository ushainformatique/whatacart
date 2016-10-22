<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace newsletter\managers;

use usni\library\components\UiTableBuilder;
use yii\db\Schema;
/**
 * NewsletterTableBuilder class file
 * @package newsletter\managers
 */
class NewsletterTableBuilder extends UiTableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => Schema::TYPE_PK,
            'store_id' => Schema::TYPE_INTEGER . '(11)',
            'to' => Schema::TYPE_INTEGER . '(11)',
            'subject' => Schema::TYPE_STRING . '(164) NOT NULL',
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return[
                ['idx_store_id', 'store_id', false],
                ['idx_to', 'to', false],
                ['idx_subject', 'subject', false],
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
