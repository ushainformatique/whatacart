<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\country\managers;

use usni\library\components\UiDataManager;
use usni\UsniAdaptor;
use common\modules\localization\modules\country\models\Country;
use usni\library\utils\StatusUtil;
/**
 * Loads default data related to country.
 * 
 * @package common\modules\localization\modules\country\managers
 */
class CountryDataManager extends UiDataManager
{   
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return Country::className();
    }

    /**
     * @inheritdoc
     */
    public static function getDefaultDataSet()
    {
         return [
                    [
                        'name'              => UsniAdaptor::t('zone', 'India'),
                        'iso_code_2'        => 'IN',
                        'iso_code_3'        => 'IND',
                        'status'            => StatusUtil::STATUS_ACTIVE,
                        'address_format'    => '',
                        'postcode_required' => 0
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
}