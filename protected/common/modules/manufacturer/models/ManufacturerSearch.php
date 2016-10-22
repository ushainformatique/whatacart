<?php
/**
 * @copyright Copyright (C) 2016 Usha Singhai Neo Informatique Pvt. Ltd
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 */
namespace common\modules\manufacturer\models;

use yii\data\ActiveDataProvider;
use yii\base\Model;
use usni\UsniAdaptor;
use usni\library\utils\AdminUtil;
/**
 * ManufacturerSearch class file
 * This is the search class for model Manufacturer.
 *
 * @package common\modules\manufacturer\models
 */
class ManufacturerSearch extends Manufacturer 
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Manufacturer::tableName();
    }
    
    /**
     * @inheritdoc
     */
	public function rules()
	{
		return [
                    [['id', 'name', 'status'],       'safe'],
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
     * @return ActiveDataProvider
     */
    public function search()
    {
        $tableName      = Manufacturer::tableName();
        $query          = Manufacturer::find();
        $dataProvider   = new ActiveDataProvider([
            'query' => $query,
        ]);

        // Validate data
        if (!$this->validate())
        {
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'status', $this->status]);
        $user     = UsniAdaptor::app()->user->getUserModel();
        if(!AdminUtil::doesUserHaveOthersPermissionsOnModel(Manufacturer::className(), $user))
        {
            $query->andFilterWhere([$tableName . '.created_by' => $user->id]);
        }
        return $dataProvider;
    }
}