<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\db;

/**
 * TableManager class file.
 * 
 * @package customer\db
 */
class TableManager extends \usni\library\db\TableManager
{
    /**
     * Get table builder config.
     * @return array
     */
    protected static function getTableBuilderConfig()
    {
        return [
            CustomerTableBuilder::className(),
            CustomerMetadataTableBuilder::className(),
            CustomerOnlineTableBuilder::className(),
            CustomerActivityTableBuilder::className(),
        ];
    }
}
