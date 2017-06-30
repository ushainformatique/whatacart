<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\currency\db;

use usni\library\db\DataManager;
use common\modules\localization\modules\currency\models\Currency;
use usni\library\utils\StatusUtil;
use usni\UsniAdaptor;
/**
 * Loads default data related to currency.
 * 
 * @package common\modules\localization\modules\currency\db
 */
class CurrencyDataManager extends DataManager
{   
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return Currency::className();
    }

    /**
     * @inheritdoc
     */
    public function getDefaultDataSet()
    {
        return [
                    [
                        'name'           => UsniAdaptor::t('currency', 'US Dollars'),
                        'code'           => 'USD', 
                        'symbol_left'    => '$',
                        'symbol_right'   => '',
                        'decimal_place'  => 2,
                        'value'          => 1,
                        'status'         => StatusUtil::STATUS_ACTIVE
                    ],
                    [
                        'name'           => UsniAdaptor::t('currency', 'Pound Sterling'),
                        'code'           => 'GBP', 
                        'symbol_left'    => '£',
                        'symbol_right'   => '',
                        'decimal_place'  => 2,
                        'value'          => 0.5844,
                        'status'         => StatusUtil::STATUS_ACTIVE
                    ],
                ];
    }
}