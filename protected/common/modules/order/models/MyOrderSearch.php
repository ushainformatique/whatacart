<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\models;

use yii\base\Model;
use usni\UsniAdaptor;
use usni\library\modules\users\models\Address;
use yii\data\Sort;
use usni\library\dataproviders\ArrayRecordDataProvider;
use products\behaviors\PriceBehavior;
use common\modules\order\business\Manager as OrderBusinessManager;
/**
 * MyOrderSearch class file
 * This is the search class for model Order.
 *
 * @package common\modules\order\models
 */
class MyOrderSearch extends Order 
{
    use \usni\library\traits\SearchTrait;
    use \common\modules\payment\traits\PaymentTrait;
    /**
     * Payment method
     * @var string 
     */
    public $payment_method;
    
    /**
     * Order amount.
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
                    [['status', 'customer_id', 'shipping', 'unique_id', 'payment_method', 'amount', 'created_datetime'],    'safe'],
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
     * @return ArrayRecordDataProvider
     */
    public function search()
    {
        $query                  = new \yii\db\Query();
        $tableName              = UsniAdaptor::tablePrefix() . 'order';
        $extensionTable         = UsniAdaptor::tablePrefix() . 'extension';
        $trExtensionTable       = UsniAdaptor::tablePrefix() . 'extension_translated';
        $orderAddressDetails    = UsniAdaptor::tablePrefix() . 'order_address_details';
        $orderPaymentDetails    = UsniAdaptor::tablePrefix() . 'order_payment_details';
        $orderInvoice           = UsniAdaptor::tablePrefix() . 'invoice';
        $currentStoreId         = UsniAdaptor::app()->storeManager->selectedStoreId;
        $query->select(["ot.*", "et.code", "ett.name", "CONCAT_WS(' ', oad.firstname, oad.lastname) AS username", "opd.shipping_fee", "opd.payment_method", "opd.total_including_tax", "oi.id AS invoice_id", "(opd.total_including_tax + opd.shipping_fee) AS amount"])
              ->from(["$tableName ot"])
              ->innerJoin("$orderAddressDetails oad", "ot.id = oad.order_id AND oad.type = :type", [':type' => Address::TYPE_BILLING_ADDRESS])
              ->innerJoin("$orderPaymentDetails opd", "ot.id = opd.order_id")
              ->innerJoin("$orderInvoice oi", "ot.id = oi.order_id")
              ->leftJoin("$extensionTable et", "ot.shipping = et.code AND et.category = :cat", [':cat' => 'shipping'])
              ->leftJoin("$trExtensionTable ett", "et.id = ett.owner_id AND ett.language = :lan", [':lan' => UsniAdaptor::app()->languageManager->selectedLanguage])
              ->where('ot.store_id = :sid AND ot.customer_id = :cid', [':sid' => $currentStoreId, ':cid' => $this->getUserId()]);
        
        $dataProvider   = new ArrayRecordDataProvider([
            'query' => $query,
            'key'   => 'id'
        ]);
        $sort = new Sort(['attributes' => ['unique_id', 'status', 'amount', 'created_datetime']]);
        $dataProvider->setSort($sort);
        // Validate data
        if (!$this->validate())
        {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'ot.unique_id', $this->unique_id]);
        $query->andFilterWhere(['like', 'tc.username', $this->customer_id]);
        $query->andFilterWhere(['like', 'ett.name', $this->shipping]);
        $query->andFilterWhere(['ot.status' => $this->status]);
        $query->andFilterWhere(['(opd.total_including_tax + opd.shipping_fee)' => $this->amount]);
        $query->andFilterWhere(['like', 'ot.created_datetime', $this->created_datetime]);
        $this->attachBehavior('priceBehavior', PriceBehavior::className());
        $models = $dataProvider->getModels();
        foreach($models as $index => $model)
        {
            $currencySymbol     = UsniAdaptor::app()->currencyManager->getCurrencySymbol($model['currency_code']);
            $model['amount']    = $this->getPriceWithSymbol(OrderBusinessManager::getInstance()->getAmount($model), $currencySymbol);
            $models[$index]     = $model;
        }
        $dataProvider->setModels($models);
        return $dataProvider;
    }
}