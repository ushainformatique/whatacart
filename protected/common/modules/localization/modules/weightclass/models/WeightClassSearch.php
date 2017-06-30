<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\weightclass\models;

use yii\base\Model;
use usni\UsniAdaptor;
use usni\library\dataproviders\ArrayRecordDataProvider;
/**
 * WeightClassSearch class file
 * This is the search class for model WeightClass.
 *
 * @package common\modules\localization\modules\weightclass\models
 */
class WeightClassSearch extends WeightClass
{
    use \usni\library\traits\SearchTrait;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return WeightClass::tableName();
    }

	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name', 'value', 'unit'], 'safe'],
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
        $tableName      = UsniAdaptor::tablePrefix() . 'weight_class';
        $trTableName    = UsniAdaptor::tablePrefix() . 'weight_class_translated';
        $query->select('w.*, wt.name')
              ->from(["$tableName w"])
              ->innerJoin("$trTableName wt", 'w.id = wt.owner_id')
              ->where('wt.language = :lang', [':lang' => $this->language]);
        $dataProvider = new ArrayRecordDataProvider([
                                                        'query'     => $query,
                                                        'key'       => 'id',
                                                        'sort'      => ['attributes' => ['name', 'value', 'unit']]
                                                   ]);

        if (!$this->validate()) 
        {
            return $dataProvider;
        }        
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'value', $this->value]);
        $query->andFilterWhere(['like', 'unit', $this->unit]);
        if($this->canAccessOwnedRecordsOnly('weightclass'))
        {
            $query->andFilterWhere(['w.created_by' => $this->getUserId()]);
        }
        return $dataProvider;
    }
}