<?php
namespace common\modules\order\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use usni\UsniAdaptor;
use usni\library\utils\AdminUtil;
/**
 * InvoiceSearch class file
 * This is the search class for model Invoice.
 * 
 * @package common\modules\order\models
 */
class InvoiceSearch extends Invoice 
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Invoice::tableName();
    }
    
    /**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['order_id', 'unique_id', 'price_excluding_tax', 'tax', 'total_items', 'shipping_fee'], 'safe'],
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
        $query          = Invoice::find();
        $tableName      = Invoice::tableName();
        $dataProvider   = new ActiveDataProvider([
            'query' => $query,
        ]);

        // Validate data
        if (!$this->validate())
        {
            return $dataProvider;
        }
        $query->andFilterWhere(['order_id' => $this->order_id]);
        $query->andFilterWhere(['unique_id' => $this->unique_id]);
        $query->andFilterWhere(['price_excluding_tax' => $this->price_excluding_tax]);
        $query->andFilterWhere(['tax' => $this->tax]);
        $query->andFilterWhere(['total_items' => $this->total_items]);
        $query->andFilterWhere(['shipping_fee' => $this->shipping_fee]);
        $user     = UsniAdaptor::app()->user->getUserModel();
        if(!AdminUtil::doesUserHaveOthersPermissionsOnModel(Invoice::className(), $user))
        {
            $query->andFilterWhere([$tableName . '.created_by' => $user->id]);
        }
        return $dataProvider;
    }
}