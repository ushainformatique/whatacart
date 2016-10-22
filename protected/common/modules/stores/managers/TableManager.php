<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\managers;

use common\modules\stores\managers\StoreTableBuilder;
use common\modules\stores\managers\StoreConfigurationTableBuilder;
/**
 * TableManager class file.
 * @package common\modules\stores\managers
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
            StoreTableBuilder::className(),
            StoreConfigurationTableBuilder::className()
        ];
    }
}
