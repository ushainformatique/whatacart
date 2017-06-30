<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\db;

use usni\library\db\TableBuilder;
/**
 * CustomerDownloadMappingTableBuilder class file.
 *
 * @package products\db
 */
class CustomerDownloadMappingTableBuilder extends TableBuilder
{
    /**
     * @inheritdoc
     */
    protected function getTableSchema()
    {
        return [
            'customer_id' => $this->integer(11),
            'download_id' => $this->integer(11),
        ];
    }
    
    /**
     * @inheritdoc
     */
    protected function getIndexes()
    {
        return [
                    ['idx_customer_id', 'customer_id', false],
                    ['idx_download_id', 'download_id', false],
               ];
    }
}