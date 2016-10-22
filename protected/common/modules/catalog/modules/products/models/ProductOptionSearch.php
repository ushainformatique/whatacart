<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace products\models;

use yii\base\Model;
use usni\UsniAdaptor;
use usni\library\utils\AdminUtil;
use usni\library\components\TranslatedActiveDataProvider;
/**
 * ProductOptionSearch class file
 * This is the search class for model ProductOption.
 *
 * @package products\models
 */
class ProductOptionSearch extends ProductOption
{
    /**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name', 'display_name'], 'safe'],
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
     * @inheritdoc
     */
    public function __get($name)
    {
        if (in_array($name, $this->translationAttributes))
        {
            $model = parent::getTranslation();
            return $model->$name;
        }
        return parent::__get($name);
    }

    /**
     * Search based on get params.
     *
     * @return yii\data\ActiveDataProvider
     */
    public function search()
    {
        $query          = ProductOption::find();
        $dataProvider   = new TranslatedActiveDataProvider([
            'query' => $query,
        ]);
        // Validate data
        if (!$this->validate())
        {
            return $dataProvider;
        }
        $query->innerJoinWith('translations');
        $query->andFilterWhere(['language' => UsniAdaptor::app()->languageManager->getContentLanguage()]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'display_name', $this->display_name]);
        $user     = UsniAdaptor::app()->user->getUserModel();
        if(!AdminUtil::doesUserHaveOthersPermissionsOnModel(ProductOption::className(), $user))
        {
            $query->andFilterWhere([ProductOption::tableName() . '.created_by' => $user->id]);
        }
        return $dataProvider;
    }
}