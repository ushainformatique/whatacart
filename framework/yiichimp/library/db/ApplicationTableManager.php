<?php
/**
 * @copyright Copyright (c) 2017 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://github.com/ushainformatique/yiichimp/blob/master/LICENSE.md
 */
namespace usni\library\db;

/**
 * ApplicationTableManager class file
 * 
 * @package usni\library\db
 */
class ApplicationTableManager extends TableManager
{
    /**
     * @inheritdoc
     */
    protected static function getTableBuilderConfig()
    {
        return [
            ConfigurationTableBuilder::className(),
            SessionTableBuilder::className()
        ];
    }
}