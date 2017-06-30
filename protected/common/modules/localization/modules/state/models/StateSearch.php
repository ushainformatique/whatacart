<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\state\models;

use yii\base\Model;
use usni\UsniAdaptor;
use usni\library\dataproviders\ArrayRecordDataProvider;
/**
 * StateSearch class file.
 * This is the search class for model State.
 * 
 * @package common\modules\localization\modules\state\models
 */
class StateSearch extends State
{
    use \usni\library\traits\SearchTrait;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return State::tableName();
    }

	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name', 'code', 'country_id', 'status'], 'safe'],
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
        $query          = new \yii\db\Query();
        $tableName      = UsniAdaptor::tablePrefix() . 'state';
        $trTableName    = UsniAdaptor::tablePrefix() . 'state_translated';
        $trCountryTable = UsniAdaptor::tablePrefix() . 'country_translated';
        $query->select('s.*, st.name, ct.name AS country')
              ->from(["$tableName s"])
              ->innerJoin("$trTableName st", 's.id = st.owner_id')
              ->innerJoin("$trCountryTable ct", 'ct.owner_id = s.country_id')
              ->where('st.language = :lang AND ct.language = :clang', [':lang' => $this->language, ':clang' => $this->language]);
        $dataProvider = new ArrayRecordDataProvider([
                                                        'query'     => $query,
                                                        'key'       => 'id',
                                                        'sort'      => ['attributes' => ['name', 'code', 'country_id', 'status']]
                                                   ]);

        if (!$this->validate()) 
        {
            return $dataProvider;
        }        
        $query->andFilterWhere(['like', 'st.name', $this->name]);
        $query->andFilterWhere(['like', 's.code', $this->code]);
        $query->andFilterWhere(['s.country_id' => $this->country_id]);
        $query->andFilterWhere(['s.status' => $this->status]);
        if($this->canAccessOwnedRecordsOnly('state'))
        {
            $query->andFilterWhere(['s.created_by' => $this->getUserId()]);
        }
        return $dataProvider;
    }
}