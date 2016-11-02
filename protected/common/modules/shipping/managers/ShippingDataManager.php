<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\shipping\managers;

use usni\library\components\UiDataManager;
use common\modules\shipping\utils\flat\FlatShippingUtil;
use usni\UsniAdaptor;
use common\modules\extension\models\Extension;
use common\modules\stores\utils\StoreUtil;
use common\modules\stores\managers\StoresDataManager;
use usni\library\utils\FileUtil;
/**
 * Loads default data related to shipping.
 * 
 * @package common\modules\shipping\managers
 */
class ShippingDataManager extends UiDataManager
{   
    /**
     * @inheritdoc
     */
    public static function loadDefaultData()
    {
        static::loadDefaultDependentData();
        $installedData  = static::getUnserializedData('installdefaultdata.bin');
        $isDataLoaded   = static::checkIfClassDataLoaded($installedData);
        if($isDataLoaded)
        {
            return false;
        }
        $currentStore   = StoreUtil::getDefault('en-US');
        $path           = UsniAdaptor::getAlias('@common/modules/shipping/config');
        $subDirs        = glob($path . '/*', GLOB_ONLYDIR);
        foreach($subDirs as $subDir)
        {
            $subPath    = FileUtil::normalizePath($subDir);
            $data       = require($subPath . '/config.php');
            $extension  = new Extension(['scenario' => 'create']);
            $extension->setAttributes($data);
            $extension->save();
        }
        //Flat rate config
        $flatRateData['method_name']   = 'fixed';
        $flatRateData['calculateHandlingFee']   = 'fixed';
        $flatRateData['handlingFee']   = 0.00;
        $flatRateData['type']          = 'perItem';
        $flatRateData['applicableZones'] = FlatShippingUtil::SHIP_TO_ALL_ZONES;
        $flatRateData['specificZones'] = serialize([]);
        $flatRateData['price']  = 5.00;        
        StoreUtil::batchInsertStoreConfiguration($flatRateData, $currentStore, 'flat', 'shipping');
        static::writeFileInCaseOfOverRiddenMethod('installdefaultdata.bin');
        return true;
    }
    
    /**
     * @inheritdoc
     */
    protected static function loadDefaultDependentData()
    {
        StoresDataManager::loadDefaultData();
    }
    
    /**
     * @inheritdoc
     */
    public static function loadDemoData()
    {
        return;
    }
    
    /**
     * @inheritdoc
     */
    public static function getModelClassName()
    {
        return null;
    }
}