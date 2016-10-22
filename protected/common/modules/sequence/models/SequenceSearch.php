<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\sequence\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use usni\UsniAdaptor;
use usni\library\utils\AdminUtil;
/**
 * SequenceSearch class file
 * This is the search class for model Sequence.
 * 
 * @package common\modules\order\models
 */
class SequenceSearch extends Sequence
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Sequence::tableName();
    }
    
    /**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['invoice_sequence_no', 'customer_sequence_no', 'order_sequence_no'],       'safe'],
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
        $tableName      = Sequence::tableName();
        $query          = Sequence::find();
        $dataProvider   = new ActiveDataProvider([
            'query' => $query,
        ]);

        // Validate data
        if (!$this->validate())
        {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'invoice_sequence_no', $this->invoice_sequence_no]);
        $query->andFilterWhere(['like', 'customer_sequence_no', $this->customer_sequence_no]);
        $query->andFilterWhere(['like', 'order_sequence_no', $this->order_sequence_no]);
        $user     = UsniAdaptor::app()->user->getUserModel();
        if(!AdminUtil::doesUserHaveOthersPermissionsOnModel(Sequence::className(), $user))
        {
            $query->andFilterWhere([$tableName . '.created_by' => $user->id]);
        }
        return $dataProvider;
    }
}