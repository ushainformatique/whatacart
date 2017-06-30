<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\db;

use usni\library\db\TableBuilder;
/**
 * ProductReviewTranslatedTableBuilder class file.
 * 
 * @package products\db
 */
class ProductReviewTranslatedTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => $this->primaryKey(),
            'owner_id' => $this->integer(11)->notNull(),
            'language' => $this->string(10)->notNull(),
            'review' => $this->text(),
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