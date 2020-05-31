<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\models;

use yii\base\Model;
use usni\library\dataproviders\ArrayRecordDataProvider;
use usni\UsniAdaptor;
use usni\library\modules\users\models\Address;
use yii\data\Sort;
use products\behaviors\PriceBehavior;
use common\modules\shipping\dao\ShippingDAO;
use common\modules\order\business\Manager as OrderBusinessManager;
use common\modules\order\models\Order;
use customer\business\Manager as CustomerBusinessManager;
/**
 * OrderSearch class file
 * This is the search class for model Order.
 *
 * @package common\modules\order\models
 */
class OrderSearch extends Order 
{
    use \usni\library\traits\SearchTrait;
    use \common\modules\localization\modules\orderstatus\traits\OrderStatusTrait;
    use \common\modules\payment\traits\PaymentTrait;
    /**
     * Payment method
     * @var string 
     */
    public $payment_method;
    
    /**
     * Contain name.
     * @var string 
     */
    public $name;
    
    /**
     * Contain amount.
     * @var float 
     */
    public $amount;
    
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
	public function rules()
	{
		return [
                    [['status', 'customer_id', 'shipping', 'unique_id', 'payment_method', 'name', 'amount'],       'safe'],
               ];
	}
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }
    
    /**
     * Search based on get params.
     *
     * @return yii\data\ActiveDataProvider
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
        $currentStoreOwnerId = UsniAdaptor::app()->storeManager->selectedStore['owner_id'];
        $query->select(["DISTINCT(ot.id)", "ot.*", "opd.payment_method", "opd.total_including_tax", "opd.shipping_fee", "opd.payment_method",
                        "oi.id AS invoice_id", "CONCAT_WS(' ', oad.firstname, oad.lastname) AS name", 
                        "(opd.total_including_tax + opd.shipping_fee) AS amount", "tc.username"])
              ->from(["$tableName ot"])
              ->innerJoin("$orderAddressDetails oad", "ot.id = oad.order_id AND oad.type = :type", [':type' => Address::TYPE_BILLING_ADDRESS])
              ->innerJoin("$orderPaymentDetails opd", "ot.id = opd.order_id")
              ->innerJoin("$orderInvoice oi", "ot.id = oi.order_id")
              ->leftJoin("$customerTable tc", "ot.customer_id = tc.id")
              ->where('ot.store_id = :sid', [':sid' => $currentStoreId]);
        $dataProvider   = new ArrayRecordDataProvider([
            'query' => $query,
            'key'   => 'id'
        ]);
        $sort = new Sort(['attributes' => ['unique_id', 'name', 'customer_id', 'amount', 'status', 'shipping', 'payment_method']]);
        $dataProvider->setSort($sort);
        // Validate data
        if (!$this->validate())
        {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'ot.unique_id', $this->unique_id]);
        $query->andFilterWhere(['like', "CONCAT_WS(' ', oad.firstname, oad.lastname)", $this->name]);
        $query->andFilterWhere(['ot.customer_id' => $this->customer_id]);
        $query->andFilterWhere(['shipping' => $this->shipping]);
        $query->andFilterWhere(['ot.status' => $this->status]);
        $query->andFilterWhere(['opd.payment_method' => $this->payment_method]);
        $query->andFilterWhere(['(opd.total_including_tax + opd.shipping_fee)' => $this->amount]);
        if($this->canAccessOwnedRecordsOnly('order') && $currentStoreOwnerId != $this->getUserId())
        {
            $query->andFilterWhere(['ot.created_by' => -1]);
        }
        $this->attachBehavior('priceBehavior', PriceBehavior::className());
        $models = $dataProvider->getModels();
        foreach($models as $index => $model)
        {
            $currencySymbol                 = UsniAdaptor::app()->currencyManager->getCurrencySymbol($model['currency_code']);
            $model['payment_method_name']   = $this->getPaymentMethodName($model['payment_method']);
            $model['shipping_method_name']  = ShippingDAO::getShippingMethodName($model['shipping'], UsniAdaptor::app()->languageManager->selectedLanguage);
            $model['payment_activity_url']  = $this->getPaymentActivityUrl($model);
            $model['show_update_link']      = $this->showUpdateLink($model);
            $model['status_label']          = $this->getOrderStatusLabel($model['status']);
            $model['username']              = CustomerBusinessManager::getInstance()->getCustomer($model['customer_id']);
            $model['amount']                = $this->getPriceWithSymbol(OrderBusinessManager::getInstance()->getAmount($model), $currencySymbol);
            $models[$index]                 = $model;
        }
        $dataProvider->setModels($models);
        return $dataProvider;
    }
    
    /**
     * Get payment activity url
     * @param array $model
     * @return string
     */
    protected function getPaymentActivityUrl($model)
    {
        $paid           = OrderBusinessManager::getInstance()->getAlreadyPaidAmountForOrder($model['id']);
        $total          = $model['total_including_tax'] + $model['shipping_fee'];
        if($total - $paid > 0)
        {
            return "order/payment/add";
        }
        return null;
    }
    
    /**
     * Show update link
     * @param array $model
     * @return boolean
     */
    protected function showUpdateLink($model)
    {
        $completedStatus = $this->getStatusId(Order::STATUS_COMPLETED, $this->language);
        if($model['status'] != $completedStatus)
        {
            return true;
        }
        return false;
    }
}