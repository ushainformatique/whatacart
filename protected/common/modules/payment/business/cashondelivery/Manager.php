<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\business\cashondelivery;

use common\modules\extension\models\Extension;
use usni\UsniAdaptor;
use common\modules\order\models\Order;
use common\modules\payment\dto\CashOnDeliveryFormDTO;
use common\modules\payment\models\cashondelivery\CashOnDeliverySetting;
use common\modules\payment\db\cashondelivery\CashOnDeliveryTransactionTableBuilder;
use common\modules\payment\models\cashondelivery\CashOnDeliveryTransaction;
/**
 * Manager class file.
 * 
 * @package common\modules\payment\business\cashondelivery
 */
class Manager extends \common\modules\payment\business\Manager
{
    use \common\modules\localization\modules\orderstatus\traits\OrderStatusTrait;
    /**
     * Process change status.
     * @param integer $id
     * @param integer $status
     */
    public function processChangeStatus($id, $status)
    {
        $extension      = Extension::findOne($id);
        if($this->checkIfPaymentMethodAllowedToDeactivate() == false)
        {
            return false;
        }
        //Install/Uninstall CashOnDeliveryTransactionTableBuilder
        if($status == Extension::STATUS_ACTIVE)
        {
            //Install table
            $builderClassName = str_replace('/', '\\', CashOnDeliveryTransactionTableBuilder::className());
            $instance = new $builderClassName();
            $instance->buildTable();
            //Insert data.
            $currentStoreId     = UsniAdaptor::app()->storeManager->selectedStoreId;
            $pendingStatusId    = $this->getStatusId(Order::STATUS_PENDING, $this->language);
            $this->configManager->insertStoreConfiguration('cashondelivery', 'payment', 'order_status', $pendingStatusId, $currentStoreId);
        }
        elseif($status == Extension::STATUS_INACTIVE)
        {
            //Drop table
            $builderClassName = str_replace('/', '\\', CashOnDeliveryTransactionTableBuilder::className());
            $instance = new $builderClassName();
            $instance->dropTableIfExists($instance->getTableName());
            //Delete data
            $this->configManager->deleteStoreConfiguration('cashondelivery', 'payment');
        }
        $extension->status = $status;
        $extension->save();
        return true;
    }
    
    /**
     * Process settings.
     * @param CashOnDeliveryFormDTO $formDTO
     */
    public function processSettings($formDTO)
    {
        $model      = new CashOnDeliverySetting();
        $postData   = $formDTO->getPostData();
        if(isset($postData))
        {
            $model->attributes  = $postData;
            if($model->validate())
            {
                $this->configManager->insertOrUpdateConfiguration('cashondelivery', 'payment', 'order_status', $model->order_status, $this->selectedStoreId);
            }
            if(empty($model->errors))
            {
                $formDTO->setIsTransactionSuccess(true);
            }
        }
        else
        {
            $model->attributes  = $this->configManager->getConfigurationByCode('cashondelivery', 'payment');
        }
        $formDTO->setModel($model);
        $dropdownData = $this->getOrderStatusDropdownData();
        $formDTO->setOrderStatusDropdownData($dropdownData);
    }
    
    /**
     * Get transaction table builder class name
     * @return string
     */
    public function getTransactionTableBuilderClassName()
    {
        return CashOnDeliveryTransactionTableBuilder::className();
    }
    
    /**
     * Get transaction model class name
     * @return string
     */
    public function getTransactionModelClassName()
    {
        return CashOnDeliveryTransaction::className();
    }
}