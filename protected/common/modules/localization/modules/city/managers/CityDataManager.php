<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\city\managers;

use usni\library\components\UiDataManager;
use common\modules\localization\modules\city\models\City;
use common\modules\localization\modules\country\models\Country;
use common\modules\localization\modules\country\managers\CountryDataManager;
/**
 * Loads default data related to language.
 * 
 * @package common\modules\localization\managers
 */
class CityDataManager extends UiDataManager
{   
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return City::className();
    }

    /**
     * @inheritdoc
     */
    public static function getDefaultDataSet()
    {
        $country = Country::findByName('India');
        return [
                    [
                        'name'          => 'New Delhi',
                        'country_id'    => $country->id 
                    ],
                    [
                        'name'          => 'Panaji',
                        'country_id'    => $country->id  
                    ],
                    [
                        'name'          => 'Dispur',
                        'country_id'    => $country->id 
                    ],
                    [
                        'name'          => 'Imphal',
                        'country_id'    => $country->id 
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
        $country = Country::find()->all();
        if(empty($country))
        {
            CountryDataManager::loadDefaultData();
        }
    }
}