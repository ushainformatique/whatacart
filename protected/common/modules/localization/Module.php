<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization;

use usni\library\components\SecuredModule;
use usni\UsniAdaptor;
use common\modules\localization\modules\city\models\City;
use common\modules\localization\modules\country\models\Country;
use common\modules\localization\modules\currency\models\Currency;
use common\modules\localization\modules\state\models\State;
use common\modules\localization\modules\lengthclass\models\LengthClass;
use common\modules\localization\modules\weightclass\models\WeightClass;
use common\modules\localization\modules\stockstatus\models\StockStatus;
use common\modules\localization\modules\orderstatus\models\OrderStatus;
/**
 * Provides functionality related to entities specific to the locale.
 * 
 * @package common\modules\localization
 */
class Module extends SecuredModule
{
    /**
     * Overrides to register translations.
     */
    public function init()
    {
        parent::init();
        $this->registerTranslations();
    }

    /**
     * Registers translations.
     */
    public function registerTranslations()
    {
        UsniAdaptor::app()->i18n->translations['localization*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@approot/messages'
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function getPermissionModels()
    {
        return [
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
}