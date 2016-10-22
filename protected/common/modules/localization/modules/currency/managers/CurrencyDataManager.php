<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\currency\managers;

use usni\library\components\UiDataManager;
use common\modules\localization\modules\currency\models\Currency;
use usni\UsniAdaptor;
use usni\library\utils\StatusUtil;
/**
 * Loads default data related to currency.
 * 
 * @package common\modules\localization\modules\currency\managers
 */
class CurrencyDataManager extends UiDataManager
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
    public static function getDefaultDataSet()
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
    
    /**
     * @inheritdoc
     */
    public static function getDefaultDemoDataSet()
    {
        return [];
    }
}