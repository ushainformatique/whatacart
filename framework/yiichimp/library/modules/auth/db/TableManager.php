<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\auth\db;
/**
 * TableBuilder class file.
 * 
 * @package usni\library\modules\auth\db
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
                    AuthAssignmentTableBuilder::className(),
                    AuthPermissionTableBuilder::className(),
                    GroupTableBuilder::className(),
                    GroupMemberTableBuilder::className() 
                ];
    }
}
