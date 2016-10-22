<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\stockstatus\managers;

use usni\library\components\UiDataManager;
use common\modules\localization\modules\stockstatus\models\StockStatus;
use usni\UsniAdaptor;
/**
 * Loads default data related to stock status.
 * 
 * @package common\modules\localization\modules\stockstatus\managers
 */
class StockStatusDataManager extends UiDataManager
{   
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return StockStatus::className();
    }

    /**
     * @inheritdoc
     */
    public static function getDefaultDataSet()
    {
         return [
                    [
                        'name'      => UsniAdaptor::t('stockstatus', 'In Stock'),
                    ],
                    [
                        'name'      => UsniAdaptor::t('stockstatus', 'Out Of Stock'),
                    ]
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