<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\db;

use taxes\db\ProductTaxClassTableBuilder;
use taxes\db\TaxRuleTableBuilder;
use taxes\db\ZoneTableBuilder;
use taxes\db\TaxRuleDetailsTableBuilder;
/**
 * TableManager class file.
 * 
 * @package taxes\db
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
            ProductTaxClassTableBuilder::className(),
            TaxRuleTableBuilder::className(),
            ZoneTableBuilder::className(),
            TaxRuleDetailsTableBuilder::className()
        ];
    }
}