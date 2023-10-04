<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\notification\db;
/**
 * TableBuilder class file.
 * 
 * @package usni\library\modules\notification\managers
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
            NotificationLayoutTableBuilder::className(),
            NotificationTemplateTableBuilder::className(),
            NotificationTableBuilder::className(),
        ];
    }
}
