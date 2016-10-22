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
/**
 * ZoneSearch class file
 * This is the search class for model Zone.
 *
 * @package taxes\models
 */
class ZoneSearch extends Zone
{
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Zone::tableName();
    }
    
    /**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name', 'country_id', 'state_id'],  'safe'],
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
        $query          = Zone::find();
        $tableName      = UsniAdaptor::tablePrefix() . 'zone';
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
        $query->andFilterWhere(['like', 'name',          $this->name]);
        $query->andFilterWhere(['country_id' => $this->country_id]);
        $query->andFilterWhere(['state_id' => $this->state_id]);
        $user     = UsniAdaptor::app()->user->getUserModel();
        if(!AdminUtil::doesUserHaveOthersPermissionsOnModel(Zone::className(), $user))
        {
            $query->andFilterWhere([$tableName . '.created_by' => $user->id]);
        }
        return $dataProvider;
    }
}