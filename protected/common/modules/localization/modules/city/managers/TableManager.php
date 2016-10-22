<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\city\managers;

use common\modules\localization\modules\city\managers\CityTableBuilder;
/**
 * TableBuilder class file.
 * @package common\modules\localization\modules\city\managers
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
            CityTableBuilder::className()
        ];
    }
}
