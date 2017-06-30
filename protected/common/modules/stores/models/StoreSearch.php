<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\stores\models;

use usni\library\dataproviders\ArrayRecordDataProvider;
use yii\base\Model;
use usni\UsniAdaptor;
/**
 * StoreSearch class file
 * This is the search class for model Store.
 * 
 * @package common\modules\stores\models
 */
class StoreSearch extends Store
{
    use \usni\library\traits\SearchTrait;
    
    /**
     * inheritdoc
     */
    public static function tableName()
    {
        return Store::tableName();
    }
    
	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name', 'status'],  'safe'],
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
        $tableName      = UsniAdaptor::tablePrefix() . 'store';
        $trTableName    = UsniAdaptor::tablePrefix() . 'store_translated';
        $query          = new \yii\db\Query();
        $query->select('st.*, stt.name')
              ->from([$tableName . ' st', $trTableName . ' stt'])
              ->where('st.id = stt.owner_id AND stt.language = :language', [':language' => $this->language]);
        $dataProvider   = new ArrayRecordDataProvider([
            'query' => $query,
            'key'   => 'id',
            'sort'  => ['attributes' => ['name', 'status']]
        ]);

        // Validate data
        if (!$this->validate())
        {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'status', $this->status]);
        if($this->canAccessOwnedRecordsOnly('store'))
        {
            $query->andFilterWhere(['st.created_by' => $this->getUserId()]);
        }
        return $dataProvider;
    }
}