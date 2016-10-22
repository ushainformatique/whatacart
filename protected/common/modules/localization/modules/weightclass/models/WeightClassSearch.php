<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\weightclass\models;

use yii\base\Model;
use usni\library\components\TranslatedActiveDataProvider;
use usni\UsniAdaptor;
use usni\library\utils\AdminUtil;
/**
 * WeightClassSearch class file
 * This is the search class for model WeightClass.
 *
 * @package common\modules\localization\modules\weightclass\models
 */
class WeightClassSearch extends WeightClass
{
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
     * @return yii\data\ActiveDataProvider
     */
    public function search()
    {
        $query          = WeightClass::find();
        $tableName      = UsniAdaptor::tablePrefix() . 'weight_class';
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
        $query->andFilterWhere(['like', 'unit', $this->unit]);
        $query->andFilterWhere(['like', 'value', $this->value]);
        $user     = UsniAdaptor::app()->user->getUserModel();
        if(!AdminUtil::doesUserHaveOthersPermissionsOnModel(WeightClass::className(), $user))
        {
            $query->andFilterWhere([$tableName . '.created_by' => $user->id]);
        }
        return $dataProvider;
    }
}