<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\db;

use usni\library\db\DataManager;
use taxes\db\TaxRuleDataManager;
use taxes\db\ProductTaxClassDataManager;
use taxes\db\ZoneDataManager;
/**
 * Loads default data related to tax.
 * 
 * @package taxes\db
 */
class TaxDataManager extends DataManager
{   
    /**
     * @inheritdoc
     */
    public function loadDefaultData()
    {
        ZoneDataManager::getInstance()->loadDefaultData();
        ProductTaxClassDataManager::getInstance()->loadDefaultData();
        TaxRuleDataManager::getInstance()->loadDefaultData();
    }
    
    /**
     * @inheritdoc
     */
    public function loadDemoData()
    {
        ZoneDataManager::getInstance()->loadDemoData();
        ProductTaxClassDataManager::getInstance()->loadDemoData();
        TaxRuleDataManager::getInstance()->loadDemoData();
    }
}