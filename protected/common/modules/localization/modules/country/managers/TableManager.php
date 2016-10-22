<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\country\managers;

use common\modules\localization\modules\country\managers\CountryTableBuilder;
/**
 * TableBuilder class file.
 * @package common\modules\localization\modules\country\managers
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
            CountryTableBuilder::className()
        ];
    }
}
