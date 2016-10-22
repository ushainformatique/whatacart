<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\managers;

use usni\library\components\UiDataManager;
use taxes\models\TaxRate;
use taxes\managers\ZoneDataManager;
use taxes\models\TaxRule;
use usni\UsniAdaptor;
use taxes\models\ZoneTranslated;
/**
 * Loads default data related to tax rate.
 *
 * @package taxes\managers
 */
class TaxRateDataManager extends UiDataManager
{   
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return TaxRate::className();
    }

    /**
     * @inheritdoc
     */
    public static function getDefaultDataSet()
    {
        $zone = ZoneTranslated::find()->where('name = :name AND language = :ln', [':name' => 'North Zone', ':ln' => 'en-US'])->asArray()->one();
        return [
                    [
                        'name'          => UsniAdaptor::t('tax', 'Sales Tax'),
                        'type'          => TaxRule::TAX_TYPE_PERCENT,
                        'value'         => 4,
                        'tax_zone_id'   => $zone['owner_id']
                    ],
                    [
                        'name'          => UsniAdaptor::t('tax', 'Service Tax'),
                        'type'          => TaxRule::TAX_TYPE_PERCENT,
                        'value'         => 5,
                        'tax_zone_id'   => $zone['owner_id']
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
    }
}
