<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\shipping\dao;

use usni\UsniAdaptor;
use yii\caching\DbDependency;
use common\modules\extension\models\Extension;
/**
 * ShippingDAO class file.
 * 
 * @package common\modules\shipping\dao
 */
class ShippingDAO
{
    /**
     * Get shipping methods.
     * @return array
     */
    public static function getMethods($language)
    {
        $extensionTable         = UsniAdaptor::tablePrefix() . 'extension';
        $extensionTrTable       = UsniAdaptor::tablePrefix() . 'extension_translated';
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $extensionTable"]);
        $sql                    = "SELECT et.*, ett.name 
                                   FROM $extensionTable et, $extensionTrTable ett 
                                   WHERE et.category = :cat AND et.status = :status AND et.id = ett.owner_id AND ett.language = :lan";
        $params                 = [':status' => Extension::STATUS_ACTIVE, ':lan' => $language, ':cat' => 'shipping'];
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, $params)->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get shipping method name.
     * @param string $code
     * @return array
     */
    public static function getShippingMethodName($code, $language)
    {
        $extensionTable         = UsniAdaptor::tablePrefix() . 'extension';
        $extensionTrTable       = UsniAdaptor::tablePrefix() . 'extension_translated';
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $extensionTable"]);
        $sql                    = "SELECT ett.name 
                                   FROM $extensionTable et, $extensionTrTable ett 
                                   WHERE et.category = :cat AND et.code = :code AND et.id = ett.owner_id AND ett.language = :lan";
        $params                 = [':code' => $code, ':lan' => $language, ':cat' => 'shipping'];
        $connection             = UsniAdaptor::app()->getDb();      
        return $connection->createCommand($sql, $params)->cache(0, $dependency)->queryScalar();
    }
}
