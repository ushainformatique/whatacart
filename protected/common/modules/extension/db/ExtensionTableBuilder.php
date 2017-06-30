<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\extension\db;

use usni\library\db\TableBuilder;
/**
 * ExtensionTableBuilder class file
 *
 * @package common\modules\extension\db
 */
class ExtensionTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id'            => $this->primaryKey(11),
            'category'      => $this->string(16)->notNull(),
            'author'        => $this->string(128),
            'version'       => $this->string(10),
            'product_version'     => $this->text(),
            'status'        => $this->smallInteger(1)->notNull(),
            'code'          => $this->string(32),
            'data'          => $this->text()
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return[
                ['idx_status', 'status', false],
                ['idx_category', 'category', false],
                ['idx_code', 'code', true]
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
