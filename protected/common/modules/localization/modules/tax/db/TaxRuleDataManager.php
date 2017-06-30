<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\db;

use usni\library\db\DataManager;
use taxes\models\TaxRule;
use usni\UsniAdaptor;
use taxes\models\ProductTaxClassTranslated;
use usni\library\modules\auth\models\Group;
use taxes\models\ZoneTranslated;
/**
 * Loads default data related to tax rule.
 * 
 * @package taxes\db
 */
class TaxRuleDataManager extends DataManager
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
    public function getDefaultDataSet()
    {
        $productTaxClass    = ProductTaxClassTranslated::find()->where('name = :name AND language = :ln', 
                                                        [':name' => 'taxable goods', ':ln' => 'en-US'])->asArray()->one();
        $groupDefault       = Group::find()->where('name = :name', [':name' => 'General'])->asArray()->one();
        $groupRetailer      = Group::find()->where('name = :name', [':name' => 'Retailer'])->asArray()->one();
        $groupWholesaler    = Group::find()->where('name = :name', [':name' => 'Wholesale'])->asArray()->one();
        $zone               = ZoneTranslated::find()->where('name = :name AND language = :ln', [':name' => 'North Zone', ':ln' => 'en-US'])->asArray()->one();
        return [
                    [
                        'name'                      => UsniAdaptor::t('tax', 'Sales Tax'),
                        'productTaxClass'           => [$productTaxClass['owner_id']],
                        'based_on'                  => TaxRule::TAX_BASED_ON_SHIPPING,
                        'customerGroups'            => [$groupDefault['id'], $groupRetailer['id'], $groupWholesaler['id']],
                        'type'                      => TaxRule::TAX_TYPE_PERCENT,
                        'value'                     => 4,
                        'taxZones'                  => [$zone['owner_id']]
                    ],
                    [
                        'name'                      => UsniAdaptor::t('tax', 'Service Tax'),
                        'productTaxClass'           => [$productTaxClass['owner_id']],
                        'based_on'                  => TaxRule::TAX_BASED_ON_BILLING,
                        'customerGroups'            => [$groupDefault['id'], $groupRetailer['id'],$groupWholesaler['id']],
                        'type'                      => TaxRule::TAX_TYPE_PERCENT,
                        'value'                     => 5,
                        'taxZones'                  => [$zone['owner_id']]
                    ],
                ];
    }
}