<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\dataCategories\models;

use yii\base\Model;
use usni\UsniAdaptor;
use usni\library\dataproviders\ArrayRecordDataProvider;
/**
 * DataCategorySearch class file
 * This is the search class for model DataCategory.
 *
 * @package common\modules\dataCategories\models
 */
class DataCategorySearch extends DataCategory
{
    use \usni\library\traits\SearchTrait;
    
	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                [['name', 'status'], 'safe']
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
        $query      = new \yii\db\Query();
        $tableName      = UsniAdaptor::tablePrefix() . 'data_category';
        $trTableName    = UsniAdaptor::tablePrefix() . 'data_category_translated';
        $query->select('dc.*, dct.name, dct.description')
              ->from(["$tableName dc"])
              ->innerJoin("$trTableName dct", 'dc.id = dct.owner_id')
              ->where('dct.language = :lang', [':lang' => $this->language]);
        $dataProvider = new ArrayRecordDataProvider([
                                                        'query'     => $query,
                                                        'key'       => 'id',
                                                        'sort'      => ['attributes' => ['name', 'status']]
                                                   ]);

        if (!$this->validate()) 
        {
            return $dataProvider;
        }        
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['status' => $this->status]);
        if($this->canAccessOwnedRecordsOnly('datacategory'))
        {
            $query->andFilterWhere(['dc.created_by' => $this->getUserId()]);
        }
        return $dataProvider;
    }
    
    /**
     * inheritdoc
     */
    public static function tableName()
    {
        return UsniAdaptor::tablePrefix() . 'data_category';
    }
}