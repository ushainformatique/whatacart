<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\currency\models;

use usni\library\components\TranslatedActiveDataProvider;
use yii\base\Model;
use usni\UsniAdaptor;
use usni\library\utils\AdminUtil;
/**
 * CurrencySearch class file
 * This is the search class for model Currency.
 *
 * @package common\modules\localization\modules\currency\models
 */
class CurrencySearch extends Currency
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Currency::tableName();
    }

	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name', 'code', 'symbol_left', 'symbol_right', 'decimal_place', 'value', 'status'], 'safe'],
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
     * @return usni\library\components\TranslatedActiveDataProvider
     */
    public function search()
    {
        $query          = Currency::find();
        $tableName      = UsniAdaptor::tablePrefix() . 'currency'; 
        $query->innerJoinWith('translations');
        $dataProvider   = new TranslatedActiveDataProvider([
            'query' => $query,
        ]);

        // Validate data
        if (!$this->validate())
        {
            return $dataProvider;
        }
        $query->andFilterWhere(['language' => UsniAdaptor::app()->languageManager->getContentLanguage()]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'code', $this->code]);
        $query->andFilterWhere(['like', 'symbol_left', $this->symbol_left]);
        $query->andFilterWhere(['like', 'symbol_right', $this->symbol_right]);
        $query->andFilterWhere(['like', 'decimal_place', $this->decimal_place]);
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['value' => $this->value]);
        $user     = UsniAdaptor::app()->user->getUserModel();
        if(!AdminUtil::doesUserHaveOthersPermissionsOnModel(Currency::className(), $user))
        {
            $query->andFilterWhere([$tableName . '.created_by' => $user->id]);
        }
        return $dataProvider;
    }
}