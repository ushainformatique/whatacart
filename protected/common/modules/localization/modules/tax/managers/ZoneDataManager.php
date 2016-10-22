<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\managers;

use usni\library\components\UiDataManager;
use taxes\models\Zone;
use common\modules\localization\modules\state\models\State;
use common\modules\localization\modules\state\managers\StateDataManager;
use common\modules\localization\modules\country\models\Country;
use usni\UsniAdaptor;
use common\modules\localization\modules\country\managers\CountryDataManager;
/**
 * Loads default data related to zone.
 * 
 * @package taxes\managers
 */
class ZoneDataManager extends UiDataManager
{
    const PIN_CODE_DELHI = '110005';
    const PIN_CODE_GUWAHATI = '781001';
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return Zone::className();
    }

    /**
     * @inheritdoc
     */
    public static function getDefaultDataSet()
    {
        $country    = Country::find()->where('iso_code_2 = :code', [':code' => 'IN'])->asArray()->one();
        $delhi      = State::find()->where('code = :code', [':code' => 'DE'])->asArray()->one();
        $assam      = State::find()->where('code = :code', [':code' => 'MN'])->asArray()->one();
         return [
                    [
                        'name'          => UsniAdaptor::t('zone', 'North Zone'),
                        'country_id'    => $country['id'],
                        'state_id'      => $delhi['id'],
                        'zip'           => self::PIN_CODE_DELHI,
                        'is_zip_range'  => 0,
                        'description'   => UsniAdaptor::t('zone', 'North Zone for India'),
                    ],
                    [
                        'name'          => UsniAdaptor::t('zone', 'East Zone'),
                        'country_id'    => $country['id'],
                        'state_id'      => $assam['id'],
                        'from_zip'      => '781000',
                        'to_zip'        => '781010',
                        'is_zip_range'  => 1,
                        'description'   => UsniAdaptor::t('zone', 'East Zone for India'),
                    ]
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
        StateDataManager::loadDefaultData();
        CountryDataManager::loadDefaultData();
    }
}
?>