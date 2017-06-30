<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\country\db;

use usni\library\db\DataManager;
use common\modules\localization\modules\country\models\Country;
use usni\library\utils\StatusUtil;
use usni\UsniAdaptor;
/**
 * Loads default data related to country.
 * 
 * @package common\modules\localization\modules\country\db
 */
class CountryDataManager extends DataManager
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
    public function getDefaultDataSet()
    {
         return [
                    [
                        'name'              => UsniAdaptor::t('country', 'India'),
                        'iso_code_2'        => 'IN',
                        'iso_code_3'        => 'IND',
                        'status'            => StatusUtil::STATUS_ACTIVE,
                        'address_format'    => '',
                        'postcode_required' => 0
                    ],
                ];
    }
}