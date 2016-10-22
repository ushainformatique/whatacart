<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\localization\modules\city\models;

use usni\library\components\TranslatedActiveDataProvider;
use yii\base\Model;
use usni\library\utils\AdminUtil;
use usni\UsniAdaptor;
/**
 * CitySearch class file
 * This is the search class for model City.
 * @package common\modules\localization\modules\city\models
 */
class CitySearch extends City
{
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
     * @return usni\library\components\TranslatedActiveDataProvider
     */
    public function search()
    {
        $query          = City::find();
        $tableName      = UsniAdaptor::tablePrefix() . 'city';
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
        $query->andFilterWhere(['like', 'country_id', $this->country_id]);
        $user     = UsniAdaptor::app()->user->getUserModel();
        if(!AdminUtil::doesUserHaveOthersPermissionsOnModel(City::className(), $user))
        {
            $query->andFilterWhere([$tableName . '.created_by' => $user->id]);
        }
        return $dataProvider;
    }
}