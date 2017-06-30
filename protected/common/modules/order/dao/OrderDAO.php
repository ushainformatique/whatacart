<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\dao;

use usni\UsniAdaptor;
use yii\caching\DbDependency;
use usni\library\modules\users\models\Address;
/**
 * Implement data queries related to order.
 *
 * @package common\modules\order\dao
 */
class OrderDAO
{
    /**
     * Get order address by type
     * @param int $orderId
     * @param int $type
     * @return array
     */
    public static function getOrderAddress($orderId, $type)
    {
        $orderAddressTable      = UsniAdaptor::tablePrefix() . 'order_address_details';
        $sql                    = "SELECT *
                                   FROM $orderAddressTable
                                   WHERE order_id = :id AND type = :type";
        $params                 = [':id' => $orderId, ':type' => $type];
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, $params)->queryOne();
    }
    
    /**
     * Get order product details
     * @param int $orderId
     * @param string $language
     * @param  boolean $requireProductCols
     * @return array
     */
    public static function getOrderProducts($orderId, $language, $requireProductCols = false)
    {
        $orderProductTable      = UsniAdaptor::tablePrefix() . 'order_product';
        $prTable                = UsniAdaptor::tablePrefix() . 'product';
        $prtTable               = UsniAdaptor::tablePrefix() . 'product_translated';
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $orderProductTable"]);
        $sql                    = "SELECT op.*";
        if($requireProductCols)
        {
            $sql                .= ", pr.sku, pr.image";
        }
        $sql                    .= " FROM $orderProductTable op, $prTable pr, $prtTable prt
                                   WHERE op.order_id = :oid AND op.product_id = pr.id AND pr.id = prt.owner_id AND prt.language = :lan";
        $params                 = [':oid' => $orderId, ':lan' => $language];
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, $params)->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get last order status
     * @param int $orderId
     * @return mixed
     */
    public static function getLastOrderStatus($orderId)
    {
        $historyTable           = UsniAdaptor::tablePrefix() . 'order_history';
        $sql                    = "SELECT *
                                   FROM $historyTable
                                   WHERE order_id = :oid ORDER BY created_datetime DESC";
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':oid' => $orderId])->queryOne();
    }
    
    /**
     * Get order details
     * @param int $orderId
     * @param string $language
     * @param int $storeId
     * @return array
     */
    public static function getById($orderId, $language, $storeId)
    {
        $orderTable             = UsniAdaptor::tablePrefix() . 'order';
        $orderTrTable           = UsniAdaptor::tablePrefix() . 'order_translated';
        $orderPaymentTable      = UsniAdaptor::tablePrefix() . 'order_payment_details';
        $orderPaymentTrTable    = UsniAdaptor::tablePrefix() . 'order_payment_details_translated';
        $orderAddressTable      = UsniAdaptor::tablePrefix() . 'order_address_details';
        $storeTable             = UsniAdaptor::tablePrefix() . 'store';
        $storeTrTable           = UsniAdaptor::tablePrefix() . 'store_translated';
        $currencyTable          = UsniAdaptor::tablePrefix() . 'currency';
        $sql                    = "SELECT o.*, otr.shipping_comments, 
                                   op.payment_method, op.total_including_tax, op.tax, op.payment_type,
                                   optr.comments, 
                                   toad.firstname, toad.lastname, toad.email, toad.mobilephone, 
                                   str.name as store_name, tc.symbol_left as currency_symbol
                                   FROM $orderTable o, $orderTrTable otr, $orderPaymentTable op, 
                                    $orderPaymentTrTable optr, $orderAddressTable toad,
                                    $storeTable st, $storeTrTable str, $currencyTable tc
                                   WHERE o.id = :id AND o.store_id = :sid AND o.id = otr.owner_id
                                   AND o.id = op.order_id 
                                   AND op.id = optr.owner_id AND otr.language = :lan1 
                                   AND optr.language = :lan2 
                                   AND o.id = toad.order_id AND toad.type = :type 
                                   AND o.store_id = st.id AND st.id = str.owner_id
                                   AND str.language = :lan3 AND o.currency_code = tc.code";
        $params                 = [':sid' => $storeId, ':id' => $orderId, ':lan1' => $language, ':lan2' => $language, 
                                    ':lan3' => $language, ':type' => Address::TYPE_BILLING_ADDRESS];
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, $params)->queryOne();
    }
    
    /**
     * Get latest order address by type.
     * @param integer $customerId
     * @param integer $type
     * @return array.
     */
    public static function getLatestOrderAddressByType($customerId, $type)
    {
        $orderTable             = UsniAdaptor::tablePrefix() . 'order';
        $orderAddressTable      = UsniAdaptor::tablePrefix() . 'order_address_details';
        $sql                    = "SELECT oad.*
                                   FROM $orderTable ot, $orderAddressTable oad
                                   WHERE ot.customer_id = :cid AND ot.id = oad.order_id AND oad.type = :type ORDER BY ot.created_datetime DESC LIMIT 1";
        $connection             = UsniAdaptor::app()->getDb();
        $params                 = [':cid' => $customerId, ':type' => $type];
        return $connection->createCommand($sql, $params)->queryOne();
    }
    
    /**
     * Get store\'s orders.
     * @param $sid int
     * @return array
     */
    public static function getStoreOrders($sid)
    {
        $orderTable             = UsniAdaptor::tablePrefix() . 'order';
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $orderTable"]);
        $sql                    = "SELECT ot.*
                                   FROM $orderTable ot
                                   WHERE ot.store_id = :sid";
        $connection             = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':sid' => $sid])->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get order history
     * @param int $id
     * @param string $language
     * @return array
     */
    public static function getOrderHistory($id, $language)
    {
        $tableName          = UsniAdaptor::tablePrefix() . 'order_history';
        $trTableName        = UsniAdaptor::tablePrefix() . 'order_history_translated';
        $dependency         = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $tableName"]);
        $sql                = "SELECT oh.*, oht.comment
                                   FROM $tableName oh, $trTableName oht
                                   WHERE oh.order_id = :oid AND oh.id = oht.owner_id AND oht.language = :lan";
        $connection         = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':oid' => $id, ':lan' => $language])->cache(0, $dependency)->queryAll();
    }
    
    /**
     * Get invoice.
     * @param integer $invoiceId
     * @param string $language
     * @return Invoice $record
     */
    public static function getInvoice($invoiceId, $language)
    {
        $tableName          = UsniAdaptor::tablePrefix() . 'invoice';
        $trTableName        = UsniAdaptor::tablePrefix() . 'invoice_translated';
        $orderTable         = UsniAdaptor::tablePrefix() . 'order';
        $userTable          = UsniAdaptor::tablePrefix() . 'user';
        $storeTable         = UsniAdaptor::tablePrefix() . 'store';
        $trStoreTable       = UsniAdaptor::tablePrefix() . 'store_translated';
        $personTable        = UsniAdaptor::tablePrefix() . 'person';
        $addressTable       = UsniAdaptor::tablePrefix() . 'address';
        $orderPaymentTable  = UsniAdaptor::tablePrefix() . 'order_payment_details';
        $orderAddressDetailsTable   = UsniAdaptor::tablePrefix() . 'order_address_details';
        $sql              = "SELECT ti.*, tit.terms, 
                             ot.store_id, ot.unique_id AS order_unique_id, ot.currency_code,
                             pt.email, pt.mobilephone, 
                             at.country, 
                             stt.name AS store_name,
                             opt.shipping_fee, opt.tax, opt.total_including_tax, opt.payment_method, opt.payment_type,
                             oadt.email AS customer_email, oadt.mobilephone AS customer_mobilephone
                             FROM $tableName ti, $trTableName tit, "
                              . "$orderTable ot, $userTable ut, "
                              . "$storeTable st, $trStoreTable stt, $personTable pt, "
                              . "$addressTable at, $orderPaymentTable opt, "
                              . "$orderAddressDetailsTable oadt
                             WHERE ti.id = :id AND ti.id = tit.owner_id AND tit.language = :lan 
                             AND ti.order_id = ot.id AND ot.store_id = st.id
                             AND st.id = stt.owner_id AND stt.language = :slang
                             AND st.owner_id = ut.id AND ut.person_id = pt.id 
                             AND pt.id = at.relatedmodel_id AND at.relatedmodel = :rm AND at.type = :type 
                             AND ot.id = opt.order_id AND ot.id = oadt.order_id AND oadt.type = :oadtype";
        $params             = [':id' => $invoiceId, ':lan' => $language, ':slang' => $language, ':rm' => 'Person', ':type' => Address::TYPE_DEFAULT, 
                               ':oadtype' => Address::TYPE_BILLING_ADDRESS];
        $connection         = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, $params)->queryOne();
    }
    
    /**
     * Get count by transaction id
     * @param string $table
     * @param string $inputTransactionId
     * @return int
     */
    public static function getCountByTransactionId($table, $inputTransactionId)
    {
        $sql        = "SELECT COUNT(*) AS cnt 
                      FROM $table 
                      WHERE transaction_id = :tid";
        $connection = UsniAdaptor::app()->getDb();
        return $connection->createCommand($sql, [':tid' => $inputTransactionId])->queryScalar();
    }
    
    /**
     * Get current store's orders for the customer
     * 
     * @param int $customerId
     * @param int $storeId
     * @return array
     */
    public static function getStoreOrdersForCustomer($customerId, $storeId)
    {
        $orderTable             = UsniAdaptor::tablePrefix() . 'order';
        $dependency             = new DbDependency(['sql' => "SELECT MAX(modified_datetime) FROM $orderTable"]);
        $sql                    = "SELECT ot.*
                                   FROM $orderTable ot
                                   WHERE ot.store_id = :sid AND ot.customer_id = :cid";
        $connection             = UsniAdaptor::app()->getDb();
        $records                = $connection->createCommand($sql, [':sid' => $storeId, ':cid' => $customerId])->cache(0, $dependency)->queryAll();
        return $records;
    }
    
    /**
     * Get orders by attribute.
     * @param string $attribute
     * @param string $value
     * @param string $language
     * @return array.
     */
    public static function getOrdersByAttribute($attribute, $value, $language)
    {
        $orderTable             = UsniAdaptor::tablePrefix() . 'order';
        $trOrderTable           = UsniAdaptor::tablePrefix() . 'order_translated';
        $sql                    = "SELECT ot.*
                                   FROM $orderTable ot, $trOrderTable ott
                                   WHERE ot." . $attribute  . "= :attr AND ot.id = ott.owner_id AND ott.language = :lang";
        $connection             = UsniAdaptor::app()->getDb();
        $params                 = [':attr' => $value, ':lang' => $language];
        return $connection->createCommand($sql, $params)->queryAll();
    }
}
