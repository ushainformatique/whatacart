<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\lengthclass\models;

use yii\base\Model;
use usni\UsniAdaptor;
use usni\library\dataproviders\ArrayRecordDataProvider;
/**
 * LengthClassSearch class file
 * This is the search class for model LengthClass.
 * 
 * @package common\modules\localization\modules\lengthclass\models
 */
class LengthClassSearch extends LengthClass
{
    use \usni\library\traits\SearchTrait;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return LengthClass::tableName();
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
        $tableName      = UsniAdaptor::tablePrefix() . 'length_class';
        $trTableName    = UsniAdaptor::tablePrefix() . 'length_class_translated';
        $query->select('l.*, lt.name')
              ->from(["$tableName l"])
              ->innerJoin("$trTableName lt", 'l.id = lt.owner_id')
              ->where('lt.language = :lang', [':lang' => $this->language]);
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
        if($this->canAccessOwnedRecordsOnly('lengthclass'))
        {
            $query->andFilterWhere(['l.created_by' => $this->getUserId()]);
        }
        return $dataProvider;
    }
}