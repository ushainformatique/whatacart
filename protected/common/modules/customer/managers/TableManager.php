<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace customer\managers;

use customer\managers\CustomerTableBuilder;
use customer\managers\CustomerMetadataTableBuilder;
/**
 * TableBuilder class file.
 * @package customer\managers
 */
class TableManager extends \usni\library\components\UiTableManager
{
    /**
     * Get table builder config.
     * @return array
     */
    protected static function getTableBuilderConfig()
    {
        return [
            CustomerTableBuilder::className(),
            CustomerMetadataTableBuilder::className()
        ];
    }
}
