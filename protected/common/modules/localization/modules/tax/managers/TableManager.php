<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\managers;

use taxes\managers\ProductTaxClassTableBuilder;
use taxes\managers\TaxRateTableBuilder;
use taxes\managers\TaxRuleTableBuilder;
use taxes\managers\ZoneTableBuilder;
use taxes\managers\TaxRuleDetailsTableBuilder;
/**
 * TableManager class file.
 * @package taxes\managers
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
            ProductTaxClassTableBuilder::className(),
            TaxRateTableBuilder::className(),
            TaxRuleTableBuilder::className(),
            ZoneTableBuilder::className(),
            TaxRuleDetailsTableBuilder::className()
        ];
    }
}
