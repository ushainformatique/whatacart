<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\sequence\db;

use common\modules\sequence\db\SequenceTableBuilder;
/**
 * TableManager class file.
 * 
 * @package common\modules\manufacturer\db
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
            SequenceTableBuilder::className(),
        ];
    }
}
