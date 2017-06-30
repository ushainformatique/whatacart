<?php
namespace common\modules\order\db;

use usni\library\db\TableBuilder;
use yii\db\Schema;
/**
 * InvoiceTranslatedTableBuilder class file.
 * 
 * @package common\modules\order\db
 */
class InvoiceTranslatedTableBuilder extends TableBuilder
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
        return $this->getCommonTranslatedAttributesIndexes();
    }
}