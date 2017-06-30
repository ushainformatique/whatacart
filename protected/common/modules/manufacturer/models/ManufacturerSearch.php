<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\manufacturer\models;

use yii\base\Model;
use usni\UsniAdaptor;
use usni\library\dataproviders\ArrayRecordDataProvider;
/**
 * ManufacturerSearch class file
 * This is the search class for model Manufacturer.
 *
 * @package common\modules\manufacturer\models
 */
class ManufacturerSearch extends Manufacturer 
{
    use \usni\library\traits\SearchTrait;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Manufacturer::tableName();
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
     * @return ArrayDataProvider
     */
    public function search()
    {
        $tableName  = UsniAdaptor::tablePrefix() . 'manufacturer';
        $query      = new \yii\db\Query();
        $query->select("m.*")->from(["$tableName m"]);
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
        if($this->canAccessOwnedRecordsOnly('manufacturer'))
        {
            $query->andFilterWhere(['m.created_by' => $this->getUserId()]);
        }
        return $dataProvider;
    }
}