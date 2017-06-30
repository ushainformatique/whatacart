<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\models;

use usni\UsniAdaptor;
use yii\base\Model;
use usni\library\dataproviders\ArrayRecordDataProvider;
use taxes\behaviors\TaxRuleBehavior;
/**
 * TaxRuleSearch class file
 * This is the search class for model TaxRule.
 *
 * @package taxes\models
 */
class TaxRuleSearch extends TaxRule
{
    use \usni\library\traits\SearchTrait;
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TaxRuleBehavior::className()
        ];
    }
    
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return TaxRule::tableName();
    }
    
    /**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name', 'based_on', 'customerGroups'],  'safe'],
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
        $tableName      = UsniAdaptor::tablePrefix() . 'tax_rule';
        $trTableName    = UsniAdaptor::tablePrefix() . 'tax_rule_translated';
        $query->select('tr.*, trt.name')
              ->from(["$tableName tr"])
              ->innerJoin("$trTableName trt", 'tr.id = trt.owner_id')
              ->where('trt.language = :lang', [':lang' => $this->language]);
        $dataProvider = new ArrayRecordDataProvider([
                                                        'query'     => $query,
                                                        'key'       => 'id',
                                                        'sort'      => ['attributes' => ['name', 'based_on']]
                                                   ]);

        if (!$this->validate()) 
        {
            return $dataProvider;
        }        
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'based_on',  $this->based_on]);
        $query->andFilterWhere(['customer_group_id' => $this->customerGroups]);
        if($this->canAccessOwnedRecordsOnly('taxrule'))
        {
            $query->andFilterWhere(['tr.created_by' => $this->getUserId()]);
        }
        $models = $dataProvider->getModels();
        foreach($models as $index => $model)
        {
            $model['based_on_value'] = $this->getBasedOnDisplayValue($model);
            $model['customer_group'] = $this->getCustomerGroupByTaxRuleDetails($model['id']);
            $models[$index] = $model;
        }
        $dataProvider->setModels($models);
        return $dataProvider;
    }
}