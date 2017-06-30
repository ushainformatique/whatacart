<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\payment\dao;

use usni\UsniAdaptor;
use common\modules\extension\models\Extension;
use common\modules\extension\models\ExtensionTranslated;
use yii\caching\DbDependency;
/**
 * Implements data access functionality related to payment.
 *
 * @package common\modules\payment\dao
 */
class PaymentDAO
{
    /**
     * Get payment method dropdown.
     * @return array
     */
    public static function getPaymentMethods($language)
    {
        $extensionTable         = Extension::tableName();
        $extensionTrTable       = ExtensionTranslated::tableName();
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $extensionTable"]);
        $sql                    = "SELECT et.*, ett.name 
                                   FROM $extensionTable et, $extensionTrTable ett 
                                   WHERE et.category = :cat AND et.status = :status AND et.id = ett.owner_id AND ett.language = :lan";
        $params                 = [':status' => Extension::STATUS_ACTIVE, ':lan' => $language, ':cat' => 'payment'];
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, $params)->cache(0, $dependency)->queryAll();
    }
}
