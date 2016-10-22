<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\shipping\managers;

use common\modules\shipping\managers\ShippingTableBuilder;
/**
 * TableManager class file.
 * @package common\modules\manufacturer\managers
 */
class TableManager extends \usni\library\components\UiTableManager
{
    /**
     * @inheritdoc
     */
    protected static function getTableBuilderConfig()
    {
        return [
                   //ShippingTableBuilder::className()
               ];
    }
}
