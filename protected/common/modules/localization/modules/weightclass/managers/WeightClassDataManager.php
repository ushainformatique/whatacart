<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\weightclass\managers;

use usni\library\components\UiDataManager;
use common\modules\localization\modules\weightclass\models\WeightClass;
use usni\UsniAdaptor;
/**
 * Loads default data related to weight class.
 * 
 * @package common\modules\localization\modules\weightclass\managers
 */
class WeightClassDataManager extends UiDataManager
{   
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return WeightClass::className();
    }

    /**
     * @inheritdoc
     */
    public static function getDefaultDataSet()
    {
         return [
                    [
                        'name'      => UsniAdaptor::t('weightclass', 'Kilogram'),
                        'unit'     => 'kg',
                        'value'      => 1.00
                    ],
                    [
                        'name'      => UsniAdaptor::t('weightclass', 'Gram'),
                        'unit'     => 'g',
                        'value'      => 1000.00
                    ],
                    [
                        'name'      => UsniAdaptor::t('weightclass', 'Ounce'),
                        'unit'     => 'oz',
                        'value'      => 35.27
                    ],
                    [
                        'name'      => UsniAdaptor::t('weightclass', 'Pound'),
                        'unit'      => 'lb',
                        'value'     => 2.20
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