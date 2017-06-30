<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\shipping\business\flat;

use common\modules\extension\models\Extension;
use usni\UsniAdaptor;
use common\modules\stores\business\ConfigManager;
use common\modules\shipping\utils\flat\FlatShippingUtil;
use common\modules\shipping\dto\FlatShippingFormDTO;
use common\modules\shipping\models\flat\FlatRateEditForm;
use taxes\models\ZoneTranslated;
use usni\library\utils\ArrayUtil;
/**
 * Manager class file.
 * 
 * @package common\modules\shipping\business\flat
 */
class Manager extends \common\modules\shipping\business\Manager
{
    /**
     * Process change status.
     * @param integer $id
     * @param integer $status
     */
    public function processChangeStatus($id, $status)
    {
        if($this->checkIfShippingMethodAllowedToDeactivate('flat') == false)
        {
            return false;
        }
        $storeConfigManager = new ConfigManager();
        if($status == Extension::STATUS_ACTIVE)
        {
            //Flat rate config
            $flatRateData['method_name']   = 'fixed';
            $flatRateData['calculateHandlingFee']   = 'fixed';
            $flatRateData['handlingFee']   = 0.00;
            $flatRateData['type']          = 'perItem';
            $flatRateData['applicableZones'] = FlatShippingUtil::SHIP_TO_ALL_ZONES;
            $flatRateData['specificZones'] = serialize([]);
            $flatRateData['price']  = 5.00;        
            $storeConfigManager->batchInsertStoreConfiguration($flatRateData, UsniAdaptor::app()->storeManager->selectedStoreId, 'flat', 'shipping');
        }
        elseif($status == Extension::STATUS_INACTIVE)
        {
            $storeConfigManager->deleteStoreConfiguration('flat', 'shipping');
        }
        $extension = Extension::findOne($id);
        $extension->status = $status;
        $extension->save();
        return true;
    }
    
    /**
     * Process settings.
     * @param FlatShippingFormDTO $formDTO
     */
    public function processSettings($formDTO)
    {
        $storeConfigManager = new ConfigManager();
        $model              = new FlatRateEditForm();
        $postData           = $formDTO->getPostData();
        if (isset($postData['FlatRateEditForm']))
        {
            $model->attributes = $postData['FlatRateEditForm'];
            if($model->applicableZones == FlatShippingUtil::SHIP_TO_ALL_ZONES)
            {
                $model->specificZones = [];
            }
            $model->specificZones = serialize($model->specificZones);
            $storeConfigManager->processInsertOrUpdateConfiguration($model, 'flat', 'shipping', $this->selectedStoreId);
            $formDTO->setIsTransactionSuccess(true);
            //Unserialize
            $model->specificZones = unserialize($model->specificZones);
        }
        else
        {
            $model->attributes    = $storeConfigManager->getConfigurationByCode('flat', 'shipping');
            $model->specificZones = unserialize($model->specificZones);
        }
        $formDTO->setModel($model);
        $zoneDropdownData = $this->getZoneDropdownData();
        $formDTO->setZoneDropdownData($zoneDropdownData);
    }
    
    /**
     * Get zone dropdown data.
     * @return array
     */
    protected function getZoneDropdownData()
    {
        $zone = ZoneTranslated::find()->asArray()->all();
        return ArrayUtil::map($zone, 'owner_id', 'name');
    }
}
