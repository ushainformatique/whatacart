<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\manufacturer\managers;

use usni\library\components\UiDataManager;
use common\modules\manufacturer\models\Manufacturer;
use usni\library\utils\StatusUtil;
/**
 * Loads default data related to manufacturer.
 * 
 * @package common\modules\manufacturer\managers
 */
class ManufacturerDataManager extends UiDataManager
{
    /**
     * @inheritdoc
     */
    public static function getDefaultDataSet()
    {
        return [
                    [
                        'name'              => 'Apple',
                        'status'            => StatusUtil::STATUS_ACTIVE,
                    ],
                    [
                        'name'              => 'Canon',
                        'status'            => StatusUtil::STATUS_ACTIVE
                    ],
                    [
                        'name'              => 'HTC',
                        'status'            => StatusUtil::STATUS_ACTIVE
                    ],
                    [
                        'name'              => 'Sony',
                        'status'            => StatusUtil::STATUS_ACTIVE
                    ]
               ];
    }
    
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return Manufacturer::className();
    }
    
    /**
     * @inheritdoc
     */
    public static function getDefaultDemoDataSet()
    {
        return [];
    }
}