<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\localization\utils;

use usni\library\utils\PermissionUtil;
use common\modules\localization\modules\language\models\Language;
use common\modules\localization\modules\city\models\City;
use common\modules\localization\modules\country\models\Country;
use common\modules\localization\modules\currency\models\Currency;
use common\modules\localization\modules\state\models\State;
use common\modules\localization\modules\lengthclass\models\LengthClass;
use common\modules\localization\modules\weightclass\models\WeightClass;
use common\modules\localization\modules\stockstatus\models\StockStatus;
use common\modules\localization\modules\orderstatus\models\OrderStatus;
/**
 * LocalizationPermissionUtil class file.
 * 
 * @package common\modules\localization\utils
 */
class LocalizationPermissionUtil extends PermissionUtil
{

    /**
     * Gets models associated to the localization module.
     * @return array
     */
    public static function getModels()
    {
        return [
                    Language::className(),
                    City::className(),
                    Country::className(),
                    Currency::className(),
                    State::className(),
                    LengthClass::className(),
                    WeightClass::className(),
                    StockStatus::className(),
                    OrderStatus::className()
               ];
    }

    /**
     * @inheritdoc
     */
    public static function getModuleId()
    {
        return 'localization';
    }
}