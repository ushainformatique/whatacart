<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\order\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use usni\UsniAdaptor;
use usni\library\components\Sort;
/**
 * OrderPaymentTransactionMapSearch class file
 * This is the search class for model OrderPaymentTransactionMap.
 *
 * @package common\modules\order\models
 */
class OrderPaymentTransactionMapSearch extends OrderPaymentTransactionMap 
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return OrderPaymentTransactionMap::tableName();
    }
    
    /**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['amount', 'payment_method', 'transaction_record_id', 'created_datetime'], 'safe'],
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
        $currentStore   = UsniAdaptor::app()->storeManager->getCurrentStore();
        $tableName      = UsniAdaptor::tablePrefix() . 'order_payment_transaction_map';
        $ordTable       = UsniAdaptor::tablePrefix() . 'order';
        $query          = new \yii\db\Query();
        $query->select('optm.*, o.unique_id, o.currency_code')->from("$tableName optm, $ordTable o")
              ->where('o.id = optm.order_id AND o.store_id = :sid', [':sid' => $currentStore->id]);
        $dataProvider   = new ActiveDataProvider([
            'query' => $query,
            'key'   => 'id'
        ]);

        $sort = new Sort(['attributes' => ['payment_method', 'amount', 'created_datetime']]);
        $dataProvider->setSort($sort);
        // Validate data
        if (!$this->validate())
        {
            return $dataProvider;
        }
        $query->andFilterWhere(['order_id' => $this->order_id]);
        $query->andFilterWhere(['payment_method' => $this->payment_method]);
        $query->andFilterWhere(['like', 'amount', $this->amount]);
        $query->andFilterWhere(['like', 'optm.created_datetime', $this->created_datetime]);
        return $dataProvider;
    }
}