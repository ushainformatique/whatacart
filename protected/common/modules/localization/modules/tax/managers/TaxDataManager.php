<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\managers;

use usni\library\components\UiDataManager;
use taxes\managers\TaxRateDataManager;
use taxes\managers\TaxRuleDataManager;
use taxes\managers\ProductTaxClassDataManager;
use taxes\managers\ZoneDataManager;
/**
 * Loads default data related to tax rate.
 * @package taxes\managers
 */
class TaxDataManager extends UiDataManager
{   
    /**
     * @inheritdoc
     */
    public static function loadDefaultData()
    {
        ZoneDataManager::loadDefaultData();
        TaxRateDataManager::loadDefaultData();
        ProductTaxClassDataManager::loadDefaultData();
        TaxRuleDataManager::loadDefaultData();
    }
    
    /**
     * @inheritdoc
     */
    public static function loadDemoData()
    {
        ZoneDataManager::loadDemoData();
        TaxRateDataManager::loadDemoData();
        ProductTaxClassDataManager::loadDemoData();
        TaxRuleDataManager::loadDemoData();
    }
}
?>