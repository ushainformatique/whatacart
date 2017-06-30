<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\lengthclass\db;

use usni\library\db\DataManager;
use common\modules\localization\modules\lengthclass\models\LengthClass;
/**
 * Loads default data related to length class.
 * 
 * @package common\modules\localization\modules\lengthclass\db
 */
class LengthClassDataManager extends DataManager
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
    public function getDefaultDataSet()
    {
         return [
                    [
                        'name'      => 'Meter',
                        'unit'     => 'm',
                        'value'      => 1.00
                    ],
                    [
                        'name'      => 'Centimeter',
                        'unit'     => 'cm',
                        'value'      => 100.00
                    ],
                    [
                        'name'      => 'Inch',
                        'unit'     => 'in',
                        'value'      => 39.37
                    ],
                    [
                        'name'      => 'Millimeter',
                        'unit'     => 'mm',
                        'value'      => 1000.00
                    ],
                ];
    }
}