<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use usni\UsniAdaptor;
use usni\library\utils\AdminUtil;
use usni\library\modules\users\models\Address;
use usni\library\components\Sort;
/**
 * OrderSearch class file
 * This is the search class for model Order.
 *
 * @package common\modules\order\models
 */
class OrderSearch extends Order 
{
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
        $query              = new \yii\db\Query();
        $tableName          = UsniAdaptor::tablePrefix() . 'order';
        $orderAddressDetails = UsniAdaptor::tablePrefix() . 'order_address_details';
        $orderPaymentDetails = UsniAdaptor::tablePrefix() . 'order_payment_details';
        $orderInvoice       = UsniAdaptor::tablePrefix() . 'invoice';
        $customerTable      = UsniAdaptor::tablePrefix() . 'customer';
        $currentStore       = UsniAdaptor::app()->storeManager->getCurrentStore();
        $query->select(["ot.*", "opd.payment_method", "opd.total_including_tax", "opd.shipping_fee", "oi.id AS invoice_id", "CONCAT_WS(' ', oad.firstname, oad.lastname) AS name", "(opd.total_including_tax + opd.shipping_fee) AS amount"])
              ->from(["$tableName ot"])
              ->innerJoin("$orderAddressDetails oad", "ot.id = oad.order_id AND oad.type = :type", [':type' => Address::TYPE_BILLING_ADDRESS])
              ->innerJoin("$orderPaymentDetails opd", "ot.id = opd.order_id")
              ->innerJoin("$orderInvoice oi", "ot.id = oi.order_id")
              ->leftJoin("$customerTable tc", "ot.customer_id = tc.id")
              ->where('ot.store_id = :sid', [':sid' => $currentStore->id]);
        $dataProvider   = new ActiveDataProvider([
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
        $query->andFilterWhere(['ot.shipping' => $this->shipping]);
        $query->andFilterWhere(['ot.status' => $this->status]);
        $query->andFilterWhere(['opd.payment_method' => $this->payment_method]);
        $query->andFilterWhere(['(opd.total_including_tax + opd.shipping_fee)' => $this->amount]);
        $user     = UsniAdaptor::app()->user->getUserModel();
        if(!AdminUtil::doesUserHaveOthersPermissionsOnModel(Order::className(), $user))
        {
            $query->andFilterWhere(['ot.created_by' => $user->id]);
        }
        return $dataProvider;
    }
}