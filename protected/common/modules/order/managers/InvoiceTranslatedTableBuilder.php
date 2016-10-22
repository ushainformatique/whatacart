<?php
namespace common\modules\order\managers;

use usni\library\components\UiTableBuilder;
use yii\db\Schema;
/**
 * InvoiceTranslatedTableBuilder class file.
 * @package common\modules\order\managers
 */
class InvoiceTranslatedTableBuilder extends UiTableBuilder
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
            'terms' => $this->text()
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