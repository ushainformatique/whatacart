<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\models;

use usni\UsniAdaptor;
use yii\base\Model;
use usni\library\dataproviders\ArrayRecordDataProvider;
/**
 * ZoneSearch class file
 * This is the search class for model Zone.
 *
 * @package taxes\models
 */
class ZoneSearch extends Zone
{
    use \usni\library\traits\SearchTrait;
    
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Zone::tableName();
    }
    
    /**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name', 'country_id', 'state_id'],  'safe'],
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
        $tableName      = UsniAdaptor::tablePrefix() . 'zone';
        $trTableName    = UsniAdaptor::tablePrefix() . 'zone_translated';
        $trCountryTable = UsniAdaptor::tablePrefix() . 'country_translated';
        $trStateTable   = UsniAdaptor::tablePrefix() . 'state_translated';
        $query->select('z.*, zt.name, ct.name AS country, st.name AS state')
              ->from(["$tableName z"])
              ->innerJoin("$trTableName zt", 'z.id = zt.owner_id AND zt.language = :lang', [':lang'  => $this->language])
              ->leftJoin("$trCountryTable ct", 'z.country_id = ct.owner_id AND ct.language = :clang', [':clang' => $this->language])
              ->leftJoin("$trStateTable st", 'z.state_id = st.owner_id AND st.language = :slang', [':slang'    => $this->language]);
        $dataProvider = new ArrayRecordDataProvider([
                                                        'query'     => $query,
                                                        'key'       => 'id',
                                                        'sort'      => ['attributes' => ['name', 'country_id', 'state_id']]
                                                   ]);

        if (!$this->validate()) 
        {
            return $dataProvider;
        }        
        $query->andFilterWhere(['like', 'zt.name', $this->name]);
        $query->andFilterWhere(['z.country_id' => $this->country_id]);
        $query->andFilterWhere(['z.state_id' => $this->state_id]);
        if($this->canAccessOwnedRecordsOnly('zone'))
        {
            $query->andFilterWhere(['z.created_by' => $this->getUserId()]);
        }
        $models = $dataProvider->getModels();
        foreach($models as $index => $model)
        {
            if($model['country_id'] ==  -1)
            {
                $model['country'] = UsniAdaptor::t('localization', 'All Countries');
            }
            if($model['state_id'] ==  -1)
            {
                $model['state'] = UsniAdaptor::t('localization', 'All States');
            }
            $models[$index] = $model;
        }
        $dataProvider->setModels($models);
        return $dataProvider;
    }
}