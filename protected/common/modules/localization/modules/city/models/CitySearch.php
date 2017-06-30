<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\city\models;

use yii\base\Model;
use usni\UsniAdaptor;
use usni\library\dataproviders\ArrayRecordDataProvider;
/**
 * CitySearch class file.
 * 
 * This is the search class for model City.
 * @package common\modules\localization\modules\city\models
 */
class CitySearch extends City
{
    use \usni\library\traits\SearchTrait;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return City::tableName();
    }

	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name', 'country_id'], 'safe'],
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
        $query                  = new \yii\db\Query();
        $tableName              = UsniAdaptor::tablePrefix() . 'city';
        $trTableName            = UsniAdaptor::tablePrefix() . 'city_translated';
        $trCountryTranslated    = UsniAdaptor::tablePrefix() . 'country_translated';
        $query->select('c.*, ct.name, cut.name AS country_name')
              ->from(["$tableName c"])
              ->innerJoin("$trTableName ct", 'c.id = ct.owner_id')
              ->innerJoin("$trCountryTranslated cut", 'cut.owner_id = c.country_id')
              ->where('ct.language = :lang AND cut.language = :culang', [':lang' => $this->language, ':culang' => $this->language]);
        $dataProvider = new ArrayRecordDataProvider([
                                                        'query'     => $query,
                                                        'key'       => 'id',
                                                        'sort'      => ['attributes' => ['name', 'country_id']]
                                                   ]);

        if (!$this->validate()) 
        {
            return $dataProvider;
        }        
        $query->andFilterWhere(['like', 'ct.name', $this->name]);
        $query->andFilterWhere(['c.country_id' => $this->country_id]);
        if($this->canAccessOwnedRecordsOnly('city'))
        {
            $query->andFilterWhere(['c.created_by' => $this->getUserId()]);
        }
        return $dataProvider;
    }
}