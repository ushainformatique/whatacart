<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\stockstatus\models;

use yii\base\Model;
use usni\UsniAdaptor;
use usni\library\dataproviders\ArrayRecordDataProvider;
/**
 * StockStatusSearch class file
 * This is the search class for model StockStatus.
 *
 * @package common\modules\localization\modules\stockstatus\models
 */
class StockStatusSearch extends StockStatus
{
    use \usni\library\traits\SearchTrait;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return StockStatus::tableName();
    }

	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name'], 'safe'],
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
     * @return ArrayDataProvider
     */
    public function search()
    {
        $query          = new \yii\db\Query();
        $tableName      = UsniAdaptor::tablePrefix() . 'stock_status';
        $trTableName    = UsniAdaptor::tablePrefix() . 'stock_status_translated';
        $query->select('s.*, st.name')
              ->from(["$tableName s"])
              ->innerJoin("$trTableName st", 's.id = st.owner_id')
              ->where('st.language = :lang', [':lang' => $this->language]);
        $dataProvider = new ArrayRecordDataProvider([
                                                        'query'     => $query,
                                                        'key'       => 'id',
                                                        'sort'      => ['attributes' => ['name']]
                                                   ]);

        if (!$this->validate()) 
        {
            return $dataProvider;
        }        
        $query->andFilterWhere(['like', 'name', $this->name]);
        if($this->canAccessOwnedRecordsOnly('stockstatus'))
        {
            $query->andFilterWhere(['s.created_by' => $this->getUserId()]);
        }
        return $dataProvider;
    }
}