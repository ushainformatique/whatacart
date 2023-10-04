<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\modules\language\db;

use usni\library\modules\language\db\LanguageTableBuilder;
/**
 * TableBuilder class file.
 * 
 * @package usni\library\modules\language\db
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
            LanguageTableBuilder::className()
        ];
    }
}
