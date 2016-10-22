<?php
namespace common\modules\shipping\utils;

use usni\UsniAdaptor;
use common\modules\shipping\components\ShippingFactory;
use yii\caching\DbDependency;
use products\utils\ProductUtil;
use common\modules\extension\models\Extension;
use common\modules\extension\models\ExtensionTranslated;
/**
 * ShippingUtil class file.
 * 
 * @package common\modules\shipping\utils
 */
class ShippingUtil
{
    /**
     * Gets status dropdown.
     * @return array
     */
    public static function getStatusDropdown()
    {
        return array(
            Extension::STATUS_ACTIVE     => UsniAdaptor::t('application','Active'),
            Extension::STATUS_INACTIVE   => UsniAdaptor::t('application','Inactive')
        );
    }
    
    /**
     * Get shipping methods.
     * @return array
     */
    public static function getMethods()
    {
        $data = [];
        $language               = UsniAdaptor::app()->languageManager->getDisplayLanguage();
        $extensionTable         = Extension::tableName();
        $extensionTrTable       = ExtensionTranslated::tableName();
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $extensionTable"]);
        $sql                    = "SELECT et.*, ett.name 
                                   FROM $extensionTable et, $extensionTrTable ett 
                                   WHERE et.category = :cat AND et.status = :status AND et.id = ett.owner_id AND ett.language = :lan";
        $params                 = [':status' => Extension::STATUS_ACTIVE, ':lan' => $language, ':cat' => 'shipping'];
        $connection             = UsniAdaptor::app()->getDb();
        $models = $connection->createCommand($sql, $params)->cache(0, $dependency)->queryAll();
        foreach($models as $model)
        {
            $shippingFactory = new ShippingFactory(['type' => $model['code']]);
            $instance        = $shippingFactory->getInstance();
            $data[$model['code']] = $instance->getDescription();
        }
        return $data;
    }
    
    /**
     * Get shipping method name
     * @param string $code
     * @return string
     */
    public static function getShippingMethodName($code)
    {
        $language               = UsniAdaptor::app()->languageManager->getDisplayLanguage();
        $extensionTable         = Extension::tableName();
        $extensionTrTable       = ExtensionTranslated::tableName();
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $extensionTable"]);
        $sql                    = "SELECT et.*, ett.name 
                                   FROM $extensionTable et, $extensionTrTable ett 
                                   WHERE et.category = :cat AND et.code = :code AND et.id = ett.owner_id AND ett.language = :lan";
        $params                 = [':code' => $code, ':lan' => $language, ':cat' => 'shipping'];
        $connection             = UsniAdaptor::app()->getDb();      
        $model                  = $connection->createCommand($sql, $params)->cache(0, $dependency)->queryOne();
        if(!empty($model))
        {
            return $model['name'];
        }
        return null;
    }
    
    /**
     * Get calculated price by type
     * @param $type string
     * @param $cart Cart
     * @param  string $defaultCurrencyCode
     * @param  string $currencyCode
     * @return float
     */
    public static function getCalculatedPriceByType($type, $cart, $defaultCurrencyCode = null, $currencyCode = null)
    {
        $shippingFactory = new ShippingFactory(['type' => $type]);
        $instance        = $shippingFactory->getInstance();
        return ProductUtil::getPriceByCurrency($instance->getCalculatedPrice($cart), $defaultCurrencyCode, $currencyCode);
    }
}
