<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\city\db;

use usni\library\db\DataManager;
use common\modules\localization\modules\city\models\City;
use common\modules\localization\modules\country\models\Country;
/**
 * Loads default data related to language.
 * 
 * @package common\modules\localization\db
 */
class CityDataManager extends DataManager
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
    public function getDefaultDataSet()
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
}