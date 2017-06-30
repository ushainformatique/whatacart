<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\state\db;

use usni\library\db\DataManager;
use common\modules\localization\modules\state\models\State;
use usni\library\utils\StatusUtil;
use common\modules\localization\modules\country\models\Country;
use usni\UsniAdaptor;
/**
 * Loads default data related to state.
 * 
 * @package common\modules\localization\modules\state\db
 */
class StateDataManager extends DataManager
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
    public function getDefaultDataSet()
    {
        $country    = Country::find()->where('iso_code_2 = :code', [':code' => 'IN'])->asArray()->one();
        $countryId  = $country['id'];
        return [
                    [
                        'name'          => UsniAdaptor::t('state', 'Delhi'),
                        'country_id'    => $countryId,
                        'code'          => 'DE',
                        'status'        => StatusUtil::STATUS_ACTIVE
                    ],
                    [
                        'name'          => UsniAdaptor::t('state', 'Assam'),
                        'country_id'    => $countryId,
                        'code'          => 'AS',
                        'status'        => StatusUtil::STATUS_ACTIVE
                    ],
                    [
                        'name'          => UsniAdaptor::t('state', 'Goa'),
                        'country_id'    => $countryId,
                        'code'          => 'GO',
                        'status'        => StatusUtil::STATUS_ACTIVE
                    ],
                    [
                        'name'          => UsniAdaptor::t('state', 'Manipur'),
                        'country_id'    => $countryId,
                        'code'          => 'MN',
                        'status'        => StatusUtil::STATUS_ACTIVE
                    ],
                ];
    }
}