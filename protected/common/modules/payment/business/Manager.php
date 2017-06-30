<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\business;

use common\modules\extension\models\Extension;
use usni\library\utils\FileUtil;
use usni\UsniAdaptor;
use common\modules\stores\business\ConfigManager;
use Yii;
use common\modules\order\models\OrderPaymentTransactionMap;
/**
 * Manager class file.
 * 
 * @package common\modules\payment\business
 */
class Manager extends \common\business\Manager
{
    use \common\modules\payment\traits\PaymentTrait;
    
    /**
     * @var ConfigManager 
     */
    public $configManager;
    
    /**
     * inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->configManager = new ConfigManager();
    }
        
    /**
     * Process reload.
     */
    public function processReload()
    {
        $payments           = Extension::find()->where('category = :category', [':category' => 'payment'])->asArray()->all();
        $installedCodes     = [];
        foreach($payments as $payment)
        {
            $installedCodes[] = $payment['code'];
        }
        $path       = UsniAdaptor::getAlias('@common/modules/payment/config');
        $subDirs    = glob($path . '/*', GLOB_ONLYDIR);
        //If newly added
        foreach($subDirs as $subDir)
        {
            $subPath    = FileUtil::normalizePath($subDir);
            $data       = require($subPath . '/config.php');
            //If not in db
            if(!in_array($data['code'], $installedCodes))
            {
                $extension = new Extension(['scenario' => 'create']);
                $extension->setAttributes($data);
                if($extension->save())
                {
                    $installedCodes[] = $data['code'];
                }
            }
        }
        //if folder is removed
        foreach($installedCodes as $code)
        {
            $folderPath = FileUtil::normalizePath($path . '/' . $code);
            if(!file_exists($folderPath))
            {
                $payment = Extension::find()->where('code = :code AND category = :category', [':category' => 'payment', ':code' => $code])->one();
                $payment->delete();
                //Delete store configuration
                $this->configManager->deleteStoreConfiguration($code, 'payment');
            }
        }
    }
    
    /**
     * inheritdoc
     */
    public function processList($gridViewDTO) 
    {
        $gridViewDTO->getSearchModel()->category = 'payment';
        parent::processList($gridViewDTO);
    }
    
    /**
     * Save order payment transaction map
     * @param OrderPaymentTransaction $orderPaymentTransaction
     * @param double $amount
     * @param int $orderId
     * @param string $method
     * @return boolean
     */
    public function saveOrderPaymentTransactionMap($orderPaymentTransaction, $amount, $orderId, $method)
    {
        $orderPaymentTrMap = OrderPaymentTransactionMap::find()
            ->where('order_id = :oid AND transaction_record_id = :tid', [':tid' => $orderPaymentTransaction->id, ':oid' => $orderId])
            ->asArray()
            ->one();
        if (empty($orderPaymentTrMap))
        {
            Yii::info("Order payment tr map doesn't exist", static::getLogCategory());
            //Save map
            $orderPaymentTrMap = new OrderPaymentTransactionMap(['scenario' => 'create']);
            $orderPaymentTrMap->payment_method  = $method;
            $orderPaymentTrMap->order_id        = $orderId;
            $orderPaymentTrMap->amount          = $amount;
            $orderPaymentTrMap->transaction_record_id = $orderPaymentTransaction->id;
            if ($orderPaymentTrMap->save())
            {
                Yii::info("Order payment tr map save is successfull", static::getLogCategory());
                return true;
            }
        }
        else
        {
            Yii::info("Order payment tr map record exist", static::getLogCategory());
            return true;
        }
        Yii::error("Order payment tr map save fails", static::getLogCategory());
        return false;
    }
    
    /**
     * @inheritdoc
     */
    public static function getLogCategory()
    {
        return 'app';
    }
}
