<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\cms\db;
/**
 * TableBuilder class file.
 * 
 * @package common\modules\cms\db
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
                   PageTableBuilder::className(),
               ];
    }
}
