<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\state\managers;

use usni\library\components\UiDataManager;
use common\modules\localization\modules\state\models\State;
use usni\library\utils\StatusUtil;
use common\modules\localization\modules\country\models\Country;
use common\modules\localization\modules\country\managers\CountryDataManager;
use usni\UsniAdaptor;
use common\modules\localization\modules\country\tests\helpers\CountryTestHelper;
/**
 * Loads default data related to state.
 * 
 * @package common\modules\localization\modules\state\managers
 */
class StateDataManager extends UiDataManager
{   
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return State::className();
    }

    /**
     * @inheritdoc
     */
    public static function getDefaultDataSet()
    {
        $country = Country::find()->where('iso_code_2 = :code', [':code' => 'IN'])->one();
        if(empty($country))
        {
            $country = CountryTestHelper::createCountry($name);
        }
        $countryId      = $country->id;
        return [
                    [
                        'name'          => UsniAdaptor::t('zone', 'Delhi'),
                        'country_id'    => $countryId,
                        'code'          => 'DE',
                        'status'        => StatusUtil::STATUS_ACTIVE
                    ],
                    [
                        'name'          => UsniAdaptor::t('zone', 'Assam'),
                        'country_id'    => $countryId,
                        'code'          => 'AS',
                        'status'        => StatusUtil::STATUS_ACTIVE
                    ],
                    [
                        'name'          => UsniAdaptor::t('zone', 'Goa'),
                        'country_id'    => $countryId,
                        'code'          => 'GO',
                        'status'        => StatusUtil::STATUS_ACTIVE
                    ],
                    [
                        'name'          => UsniAdaptor::t('zone', 'Manipur'),
                        'country_id'    => $countryId,
                        'code'          => 'MN',
                        'status'        => StatusUtil::STATUS_ACTIVE
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
        $countries = Country::find()->all();
        if(empty($countries))
        {
            CountryDataManager::loadDefaultData();
        }
    }
}