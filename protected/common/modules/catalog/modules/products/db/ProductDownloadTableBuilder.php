<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\db;

use usni\library\db\TableBuilder;
/**
 * ProductDownloadTableBuilder class file.
 * 
 * @package products\db
 */
class ProductDownloadTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'id' => $this->primaryKey(11),
            'file' => $this->string(128),
            'type' => $this->string(10),
            'allowed_downloads' => $this->integer(10)->defaultValue(0),
            'number_of_days' => $this->integer(10)->defaultValue(0),
            'size' => $this->double(10,2),
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_type', 'type', false]
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