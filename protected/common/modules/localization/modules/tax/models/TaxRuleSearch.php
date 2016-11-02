<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace taxes\models;

use usni\library\components\TranslatedActiveDataProvider;
use usni\library\utils\AdminUtil;
use usni\UsniAdaptor;
use yii\base\Model;
use usni\library\components\Sort;
/**
 * TaxRuleSearch class file
 * This is the search class for model TaxRule.
 *
 * @package taxes\models
 */
class TaxRuleSearch extends TaxRule
{
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
     * @return yii\data\ActiveDataProvider
     */
    public function search()
    {
        $query          = TaxRule::find();
        $tableName      = UsniAdaptor::tablePrefix() . 'tax_rule';
        $query->innerJoinWith('translations');
        $query->innerJoin(TaxRuleDetails::tableName(), $tableName . '.id = tax_rule_id');
        $dataProvider   = new TranslatedActiveDataProvider([
            'query' => $query,
        ]);
        $sort = new Sort(['attributes' => ['name', 'based_on']]);
        $dataProvider->setSort($sort);
        // Validate data
        if (!$this->validate())
        {
            return $dataProvider;
        }
        $query->andFilterWhere(['language' => UsniAdaptor::app()->languageManager->getContentLanguage()]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'based_on',  $this->based_on]);
        $query->andFilterWhere(['customer_group_id' => $this->customerGroups]);
        $user     = UsniAdaptor::app()->user->getUserModel();
        if(!AdminUtil::doesUserHaveOthersPermissionsOnModel(TaxRule::className(), $user))
        {
            $query->andFilterWhere([$tableName . '.created_by' => $user->id]);
        }
        $query->groupBy('id');
        return $dataProvider;
    }
}