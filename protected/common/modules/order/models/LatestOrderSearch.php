<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\order\models;

use usni\library\modules\users\models\Address;
use common\modules\order\models\Order;
use common\modules\order\models\OrderTranslated;
use usni\UsniAdaptor;
use usni\library\dataproviders\ArrayRecordDataProvider;
use products\behaviors\PriceBehavior;
/**
 * LatestOrderSearch to get the latest order added.
 *
 * @package common\modules\order\models
 */
class LatestOrderSearch extends OrderSearch
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Order::tableName();
    }
    
    /**
     * @inheritdoc
     */
    protected function resolveTranslatedModelClassName()
    {
        return OrderTranslated::className();
    }
    
    /**
     * @inheritdoc
     */
    public function search()
    {
        $query                  = new \yii\db\Query();
        $tableName              = UsniAdaptor::tablePrefix() . 'order';
        $orderAddressDetails    = UsniAdaptor::tablePrefix() . 'order_address_details';
        $orderPaymentDetails    = UsniAdaptor::tablePrefix() . 'order_payment_details';
        $orderInvoice           = UsniAdaptor::tablePrefix() . 'invoice';
        $customerTable          = UsniAdaptor::tablePrefix() . 'customer';
        $currentStoreId         = UsniAdaptor::app()->storeManager->selectedStoreId;
        $query->select(["ot.*", "opd.payment_method", "opd.total_including_tax", "opd.shipping_fee", "opd.payment_method",
                        "oi.id AS invoice_id", "CONCAT_WS(' ', oad.firstname, oad.lastname) AS name", 
                        "(opd.total_including_tax + opd.shipping_fee) AS amount", "tc.username"])
              ->from(["$tableName ot"])
              ->innerJoin("$orderAddressDetails oad", "ot.id = oad.order_id AND oad.type = :type", [':type' => Address::TYPE_BILLING_ADDRESS])
              ->innerJoin("$orderPaymentDetails opd", "ot.id = opd.order_id")
              ->innerJoin("$orderInvoice oi", "ot.id = oi.order_id")
              ->leftJoin("$customerTable tc", "ot.customer_id = tc.id")
              ->where('ot.store_id = :sid', [':sid' => $currentStoreId])
              ->orderBy('ot.created_datetime DESC')
              ->limit(5);
        $dataProvider   = new ArrayRecordDataProvider([
            'query' => $query,
            'key'   => 'id'
        ]);
        // Validate data
        if (!$this->validate())
        {
            return $dataProvider;
        }
        if($this->canAccessOwnedRecordsOnly('order'))
        {
            $query->andFilterWhere(['ot.created_by' => $this->getUserId()]);
        }
        $this->attachBehavior('priceBehavior', PriceBehavior::className());
        $models = $dataProvider->getModels();
        foreach($models as $index => $model)
        {
            $currencySymbol                 = UsniAdaptor::app()->currencyManager->getCurrencySymbol($model['currency_code']);
            $model['amount']                = $this->getPriceWithSymbol($model['total_including_tax'] + $model['shipping_fee'], $currencySymbol);
            $model['status_label']          = $this->getOrderStatusLabel($model['status']);
            $models[$index] = $model;
        }
        $dataProvider->setModels($models);
        $dataProvider->setPagination(false);
        return $dataProvider;
    }
}
