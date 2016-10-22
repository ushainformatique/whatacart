<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\managers;

use usni\library\components\UiDataManager;
use taxes\models\TaxRule;
use taxes\managers\ZoneDataManager;
use taxes\managers\ProductTaxClassDataManager;
use common\managers\AuthDataManager;
use taxes\managers\TaxRateDataManager;
use usni\UsniAdaptor;
use taxes\models\ProductTaxClassTranslated;
use usni\library\modules\auth\models\GroupTranslated;
use taxes\models\TaxRateTranslated;
/**
 * Loads default data related to tax rule.
 * 
 * @package taxes\managers
 */
class TaxRuleDataManager extends UiDataManager
{   
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return TaxRule::className();
    }

    /**
     * @inheritdoc
     */
    public static function getDefaultDataSet()
    {
        $productTaxClass = ProductTaxClassTranslated::find()->where('name = :name AND language = :ln', 
                                                        [':name' => 'taxable goods', ':ln' => 'en-US'])->asArray()->one();
        $groupDefault    = GroupTranslated::find()->where('name = :name AND language = :ln', [':name' => 'Default', ':ln' => 'en-US'])->asArray()->one();
        $groupRetailer    = GroupTranslated::find()->where('name = :name AND language = :ln', [':name' => 'Retailer', ':ln' => 'en-US'])->asArray()->one();
        $groupWholesaler  = GroupTranslated::find()->where('name = :name AND language = :ln', [':name' => 'Wholesale', ':ln' => 'en-US'])->asArray()->one();
        $taxRateSales     = TaxRateTranslated::find()->where('name = :name AND language = :ln', [':name' => 'Sales Tax', ':ln' => 'en-US'])->asArray()->one();
        $taxRateService   = TaxRateTranslated::find()->where('name = :name AND language = :ln', [':name' => 'Service Tax', ':ln' => 'en-US'])->asArray()->one();
        return [
                    [
                        'name'                      => UsniAdaptor::t('tax', 'Sales Tax'),
                        'productTaxClass'           => [$productTaxClass['owner_id']],
                        'based_on'                  => TaxRule::TAX_BASED_ON_SHIPPING,
                        'customerGroups'            => [$groupDefault['owner_id'], $groupRetailer['owner_id'], $groupWholesaler['owner_id']],
                        'taxRates'                  => [$taxRateSales['owner_id']]
                    ],
                    [
                        'name'                      => UsniAdaptor::t('tax', 'Service Tax'),
                        'productTaxClass'           => [$productTaxClass['owner_id']],
                        'based_on'                  => TaxRule::TAX_BASED_ON_BILLING,
                        'customerGroups'            => [$groupDefault['owner_id'], $groupRetailer['owner_id'],$groupWholesaler['owner_id']],
                        'taxRates'                  => [$taxRateService['owner_id']]
                    ],
                ];
    }
    
    /**
     * @inheritdoc
     */
    public static function getDefaultDemoDataSet()
    {
        return [];
    }
    
    /**
     * @inheritdoc
     */
    protected static function loadDefaultDependentData()
    {
        ZoneDataManager::loadDefaultData();
        ProductTaxClassDataManager::loadDefaultData();
        AuthDataManager::loadDefaultData();
        AuthDataManager::loadDemoData();
        TaxRateDataManager::loadDefaultData();
    }
}