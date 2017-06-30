<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\country\models;

use yii\base\Model;
use usni\UsniAdaptor;
use usni\library\dataproviders\ArrayRecordDataProvider;
/**
 * CountrySearch class file.
 * 
 * This is the search class for model Country.
 * @package common\modules\localization\modules\country\models
 */
class CountrySearch extends Country
{
    use \usni\library\traits\SearchTrait;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Country::tableName();
    }

	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name', 'status', 'iso_code_2', 'iso_code_3'], 'safe'],
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
        $tableName      = UsniAdaptor::tablePrefix() . 'country';
        $trTableName    = UsniAdaptor::tablePrefix() . 'country_translated';
        $query->select('c.*, ct.name')
              ->from(["$tableName c"])
              ->innerJoin("$trTableName ct", 'c.id = ct.owner_id')
              ->where('ct.language = :lang', [':lang' => $this->language]);
        $dataProvider = new ArrayRecordDataProvider([
                                                        'query'     => $query,
                                                        'key'       => 'id',
                                                        'sort'      => ['attributes' => ['name', 'status', 'iso_code_2', 'iso_code_3']]
                                                   ]);

        if (!$this->validate()) 
        {
            return $dataProvider;
        }        
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['like', 'iso_code_2', $this->iso_code_2]);
        $query->andFilterWhere(['like', 'iso_code_3', $this->iso_code_3]);
        if($this->canAccessOwnedRecordsOnly('country'))
        {
            $query->andFilterWhere(['c.created_by' => $this->getUserId()]);
        }
        return $dataProvider;
    }
}