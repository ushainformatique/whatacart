<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\country\models;

use usni\library\components\TranslatedActiveDataProvider;
use yii\base\Model;
use usni\library\utils\AdminUtil;
use usni\UsniAdaptor;
/**
 * CountrySearch class file
 * This is the search class for model Country.
 * @package common\modules\localization\modules\country\models
 */
class CountrySearch extends Country
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Country::tableName();
    }

	/**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name', 'status', 'iso_code_2', 'iso_code_3'], 'safe'],
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
        $query          = Country::find();
        $tableName      = UsniAdaptor::tablePrefix(). 'country';  
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
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['like', 'iso_code_2', $this->iso_code_2]);
        $query->andFilterWhere(['like', 'iso_code_3', $this->iso_code_3]);
        $user     = UsniAdaptor::app()->user->getUserModel();
        if(!AdminUtil::doesUserHaveOthersPermissionsOnModel(Country::className(), $user))
        {
            $query->andFilterWhere([$tableName . '.created_by' => $user->id]);
        }
        return $dataProvider;
    }
}