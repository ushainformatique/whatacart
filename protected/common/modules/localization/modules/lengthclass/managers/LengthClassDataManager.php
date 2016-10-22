<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\lengthclass\managers;

use usni\library\components\UiDataManager;
use common\modules\localization\modules\lengthclass\models\LengthClass;
use usni\UsniAdaptor;
/**
 * Loads default data related to length class.
 * 
 * @package common\modules\localization\modules\lengthclass\managers
 */
class LengthClassDataManager extends UiDataManager
{   
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return LengthClass::className();
    }

    /**
     * @inheritdoc
     */
    public static function getDefaultDataSet()
    {
         return [
                    [
                        'name'      => UsniAdaptor::t('lengthclass', 'Meter'),
                        'unit'     => 'm',
                        'value'      => 1.00
                    ],
                    [
                        'name'      => UsniAdaptor::t('lengthclass', 'Centimeter'),
                        'unit'     => 'cm',
                        'value'      => 100.00
                    ],
                    [
                        'name'      => UsniAdaptor::t('lengthclass', 'Inch'),
                        'unit'     => 'in',
                        'value'      => 39.37
                    ],
                    [
                        'name'      => UsniAdaptor::t('lengthclass', 'Millimeter'),
                        'unit'     => 'mm',
                        'value'      => 1000.00
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