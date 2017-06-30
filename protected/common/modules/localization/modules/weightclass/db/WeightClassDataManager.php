<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\weightclass\db;

use usni\library\db\DataManager;
use common\modules\localization\modules\weightclass\models\WeightClass;
use usni\UsniAdaptor;
/**
 * Loads default data related to weight class.
 * 
 * @package common\modules\localization\modules\weightclass\db
 */
class WeightClassDataManager extends DataManager
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
    public function getDefaultDataSet()
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
}