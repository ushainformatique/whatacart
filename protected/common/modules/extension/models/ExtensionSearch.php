<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\extension\models;

use yii\data\ActiveDataProvider;
use yii\base\Model;
use usni\UsniAdaptor;
use usni\library\utils\AdminUtil;
/**
 * ExtensionSearch class file
 * 
 * @package common\modules\extension\models
 */
class ExtensionSearch extends Extension
{   
    /**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['name', 'author',  'version', 'product_version', 'status', 'category', 'code'],  'safe'],
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
        $query          = Extension::find();
        $tableName      = UsniAdaptor::tablePrefix() . 'extension';
        $dataProvider   = new ActiveDataProvider([
            'query' => $query,
        ]);

        // Validate data
        if (!$this->validate())
        {
            return $dataProvider;
        }
        $query->andFilterWhere(['code' => $this->code]);
        $query->andFilterWhere(['category' => $this->category]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'author', $this->author]);
        $query->andFilterWhere(['version' => $this->version]);
        $query->andFilterWhere(['like', 'product_version', $this->product_version]);
        $query->andFilterWhere(['status' => $this->status]);
        $user     = UsniAdaptor::app()->user->getUserModel();
        if(!AdminUtil::doesUserHaveOthersPermissionsOnModel(Extension::className(), $user))
        {
            $query->andFilterWhere([$tableName . '.created_by' => $user->id]);
        }
        return $dataProvider;
    }
}