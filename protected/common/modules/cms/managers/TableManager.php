<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\cms\managers;
/**
 * TableBuilder class file.
 * @package common\modules\cms\managers
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
                   PageTableBuilder::className(),
               ];
    }
}
