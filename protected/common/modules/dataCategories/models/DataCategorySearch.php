<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl.html
 */
namespace common\modules\dataCategories\models;

use usni\library\components\TranslatedActiveDataProvider;
use yii\base\Model;
use usni\UsniAdaptor;
use usni\library\utils\AdminUtil;
/**
 * DataCategorySearch class file
 * This is the search class for model DataCategory.
 *
 * @package common\modules\dataCategories\models
 */
class DataCategorySearch extends DataCategory
{
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
     * @return yii\data\ActiveDataProvider
     */
    public function search()
    {
        $query          = DataCategory::find();
        $tableName      = UsniAdaptor::tablePrefix() . 'data_category';
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
        $user     = UsniAdaptor::app()->user->getUserModel();
        if(!AdminUtil::doesUserHaveOthersPermissionsOnModel(DataCategory::className(), $user))
        {
            $query->andFilterWhere([$tableName . '.created_by' => $user->id]);
        }
        return $dataProvider;
    }
}